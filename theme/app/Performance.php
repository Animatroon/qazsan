<?php

namespace App;

class Performance
{
    public static function register(): void
    {
        add_action('wp_head', [self::class, 'preloadFonts'], 2);
        add_action('wp_head', [self::class, 'hreflangTags'], 3);
        add_filter('wp_resource_hints', [self::class, 'dnsPrefetch'], 10, 2);
        add_action('wp_head', [self::class, 'analyticsHead'], 99);
        add_action('wp_footer', [self::class, 'analyticsFooter'], 99);
        add_filter('the_content', [self::class, 'lazyLoadImages']);
        add_filter('post_thumbnail_html', [self::class, 'lazyLoadThumbnail']);
        add_action('wp_head', [self::class, 'robotsMeta'], 4);
        add_filter('wpseo_canonical', [self::class, 'ensureCanonical']);
    }

    public static function preloadFonts(): void
    {
        echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
        echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
        echo '<link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Manrope:wght@700;800&family=PT+Sans:ital,wght@0,400;0,700;1,400&display=swap">' . "\n";
    }

    public static function hreflangTags(): void
    {
        if (!function_exists('pll_the_languages')) {
            return;
        }

        $langs = pll_the_languages(['raw' => 1]);
        if (empty($langs)) {
            return;
        }

        $localeMap = ['ru' => 'ru-RU', 'kk' => 'kk-KZ'];
        $defaultUrl = '';

        foreach ($langs as $slug => $lang) {
            $hreflang = $localeMap[$slug] ?? $slug;
            $url      = esc_url($lang['url']);
            printf('<link rel="alternate" hreflang="%s" href="%s">' . "\n", esc_attr($hreflang), $url);
            if ($slug === 'ru') {
                $defaultUrl = $url;
            }
        }

        if ($defaultUrl) {
            printf('<link rel="alternate" hreflang="x-default" href="%s">' . "\n", $defaultUrl);
        }
    }

    public static function dnsPrefetch(array $hints, string $relation): array
    {
        if ($relation === 'dns-prefetch') {
            $hints[] = ['href' => '//fonts.googleapis.com'];
            $hints[] = ['href' => '//fonts.gstatic.com'];
            $hints[] = ['href' => '//www.google-analytics.com'];
            $hints[] = ['href' => '//www.googletagmanager.com'];
        }
        return $hints;
    }

    public static function analyticsHead(): void
    {
        $gtmId = qazaqstan_option('gtm_id');
        if (!$gtmId || is_admin()) {
            return;
        }
        printf(
            '<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({\'gtm.start\':new Date().getTime(),event:\'gtm.js\'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!=\'dataLayer\'?\'&l=\'+l:\'\';j.async=true;j.src=\'https://www.googletagmanager.com/gtm.js?id=\'+i+dl;f.parentNode.insertBefore(j,f);})(window,document,\'script\',\'dataLayer\',\'%s\');</script>' . "\n",
            esc_js($gtmId)
        );
    }

    public static function analyticsFooter(): void
    {
        $gtmId = qazaqstan_option('gtm_id');
        if (!$gtmId || is_admin()) {
            return;
        }
        printf(
            '<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=%s" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>' . "\n",
            esc_attr($gtmId)
        );
    }

    public static function lazyLoadImages(string $content): string
    {
        return preg_replace(
            '/<img(?![^>]*loading=)([^>]*)>/i',
            '<img loading="lazy"$1>',
            $content
        );
    }

    public static function lazyLoadThumbnail(string $html): string
    {
        if (is_admin() || strpos($html, 'loading=') !== false) {
            return $html;
        }
        return str_replace('<img ', '<img loading="lazy" ', $html);
    }

    public static function robotsMeta(): void
    {
        if (is_singular(['booking_request', 'appeal'])) {
            echo '<meta name="robots" content="noindex, nofollow">' . "\n";
        }
    }

    public static function ensureCanonical(string $canonical): string
    {
        return $canonical ?: get_permalink();
    }
}
