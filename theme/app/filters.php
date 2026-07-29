<?php

namespace App;

add_filter('excerpt_more', function () {
    return sprintf(' &hellip; <a href="%s">%s</a>', get_permalink(), __('Читать далее', 'qazaqstan'));
});

add_filter('body_class', function (array $classes): array {
    return array_merge($classes, ['wp-theme-qazaqstan']);
});

add_filter('sanitize_title', function (string $title, string $raw_title = '', string $context = 'display'): string {
    if ($context !== 'save' || $raw_title === '' || ! preg_match('/[\x{0400}-\x{04FF}]/u', $raw_title)) {
        return $title;
    }

    return qazaqstan_transliterate($raw_title);
}, 10, 3);

add_filter('redirect_canonical', function ($redirect_url, $requested_url) {
    if (! function_exists('pll_current_language') || ! is_front_page()) {
        return $redirect_url;
    }

    return false;
}, 10, 2);

foreach (['page_on_front', 'page_for_posts'] as $qazaqstan_front_option) {
    add_filter("pre_option_{$qazaqstan_front_option}", function ($value) use ($qazaqstan_front_option) {
        static $resolving = false;

        if ($resolving || is_admin() || ! function_exists('pll_current_language')) {
            return $value;
        }

        $language = pll_current_language();
        if (! $language) {
            return $value;
        }

        $resolving = true;
        $original  = (int) get_option($qazaqstan_front_option);
        $resolving = false;

        if (! $original) {
            return $value;
        }

        $translated = pll_get_post($original, $language);

        return $translated ?: $value;
    });
}

add_filter('theme_page_templates', function (array $templates): array {
    return array_merge($templates, [
        'template-about'          => __('О санатории', 'qazaqstan'),
        'template-treatment'      => __('Лечение', 'qazaqstan'),
        'template-accommodation'  => __('Проживание (Архив номеров)', 'qazaqstan'),
        'template-sport'          => __('Спорт и бассейн', 'qazaqstan'),
        'template-conferences'    => __('Конференц-залы', 'qazaqstan'),
        'template-services'       => __('Доп. услуги', 'qazaqstan'),
        'template-gallery'        => __('Галерея', 'qazaqstan'),
        'template-contacts'       => __('Контакты', 'qazaqstan'),
        'template-booking'        => __('Бронирование', 'qazaqstan'),
        'template-procurement'    => __('Госзакупки', 'qazaqstan'),
        'template-anti-corruption' => __('Антикоррупция', 'qazaqstan'),
        'template-appeal'         => __('Обращения', 'qazaqstan'),
        'template-privacy'        => __('Политика конфиденциальности', 'qazaqstan'),
    ]);
});
