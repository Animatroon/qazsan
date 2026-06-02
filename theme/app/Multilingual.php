<?php

namespace App;

class Multilingual
{
    public static function register(): void
    {
        add_action('init', [self::class, 'registerStrings'], 20);
        add_action('init', [self::class, 'configureCpt'], 20);
        add_filter('pll_get_post_types', [self::class, 'translatablePostTypes'], 10, 2);
        add_filter('pll_get_taxonomies', [self::class, 'translatableTaxonomies'], 10, 2);
        add_filter('locale', [self::class, 'setKkLocale']);
        add_filter('language_attributes', [self::class, 'addHreflang']);
    }

    public static function registerStrings(): void
    {
        if (!function_exists('pll_register_string')) {
            return;
        }

        $strings = [
            'site_name'       => get_bloginfo('name'),
            'site_description' => get_bloginfo('description'),
            'header_cta'      => __('Забронировать', 'qazaqstan'),
            'footer_tagline'  => __('Многопрофильный санаторий в Алматы. Лечение, оздоровление и отдых у подножия Алатау с 1985 года.', 'qazaqstan'),
            'footer_cta_text' => __('Оставьте заявку — подберём программу и подтвердим в течение 30 минут.', 'qazaqstan'),
            'booking_success' => __('Заявка принята! Менеджер свяжется с вами в течение 30 минут.', 'qazaqstan'),
        ];

        foreach ($strings as $name => $value) {
            pll_register_string($name, $value, 'qazaqstan');
        }
    }

    public static function configureCpt(): void
    {
        if (!function_exists('pll_is_translated_post_type')) {
            return;
        }
        $opt = get_option('polylang', []);
        $opt['post_types'] = array_unique(array_merge(
            (array) ($opt['post_types'] ?? []),
            ['room', 'doctor', 'procedure', 'conference_hall', 'service', 'testimonial', 'vacancy', 'document']
        ));
        $opt['taxonomies'] = array_unique(array_merge(
            (array) ($opt['taxonomies'] ?? []),
            ['medical_profile', 'room_type', 'amenity', 'doc_type', 'category', 'post_tag']
        ));
        update_option('polylang', $opt);
    }

    public static function translatablePostTypes(array $types, bool $hide): array
    {
        $ours = ['room', 'doctor', 'procedure', 'conference_hall', 'service', 'testimonial', 'vacancy', 'document'];
        return $hide ? $types : array_merge($types, array_combine($ours, $ours));
    }

    public static function translatableTaxonomies(array $taxs, bool $hide): array
    {
        $ours = ['medical_profile', 'room_type', 'amenity', 'doc_type'];
        return $hide ? $taxs : array_merge($taxs, array_combine($ours, $ours));
    }

    public static function setKkLocale(string $locale): string
    {
        if (function_exists('pll_current_language') && pll_current_language() === 'kk') {
            return 'kk';
        }
        return $locale;
    }

    public static function addHreflang(string $output): string
    {
        if (!function_exists('pll_current_language')) {
            return $output;
        }
        $lang = pll_current_language('locale') ?: 'ru_RU';
        $langAttr = str_replace('_', '-', $lang);
        return preg_replace('/lang="[^"]*"/', 'lang="' . esc_attr($langAttr) . '"', $output);
    }
}
