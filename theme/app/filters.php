<?php

namespace App;

add_filter('excerpt_more', function () {
    return sprintf(' &hellip; <a href="%s">%s</a>', get_permalink(), __('Читать далее', 'qazaqstan'));
});

add_filter('body_class', function (array $classes): array {
    return array_merge($classes, ['wp-theme-qazaqstan']);
});

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
