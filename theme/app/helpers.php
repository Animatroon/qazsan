<?php

if (! function_exists('qazaqstan_field')) {
    function qazaqstan_field(string $key, int|string $post_id = 0): mixed
    {
        if (function_exists('get_field')) {
            return get_field($key, $post_id ?: null);
        }
        return get_post_meta($post_id ?: get_the_ID(), $key, true);
    }
}

if (! function_exists('qazaqstan_option')) {
    function qazaqstan_option(string $key): mixed
    {
        if (function_exists('get_field')) {
            $value = get_field($key, 'option');
            if ($value !== null && $value !== false) {
                return $value;
            }
        }
        return get_option('qazaqstan_' . $key);
    }
}

if (! function_exists('qazaqstan_format_price')) {
    function qazaqstan_format_price(int|float $amount): string
    {
        return number_format($amount, 0, '.', ' ') . ' ₸';
    }
}

if (! function_exists('qazaqstan_phone_link')) {
    function qazaqstan_phone_link(string $phone): string
    {
        return 'tel:+' . preg_replace('/\D/', '', $phone);
    }
}

if (! function_exists('qazaqstan_post_gallery')) {
    function qazaqstan_post_gallery(int $post_id, mixed $acf_gallery = null): array
    {
        if (is_array($acf_gallery) && count($acf_gallery)) {
            return $acf_gallery;
        }

        $ids = [];
        if (has_post_thumbnail($post_id)) {
            $ids[] = get_post_thumbnail_id($post_id);
        }
        foreach (get_attached_media('image', $post_id) as $attachment) {
            if (! in_array($attachment->ID, $ids, true)) {
                $ids[] = $attachment->ID;
            }
        }

        return array_map(static fn (int $id): array => [
            'url'   => wp_get_attachment_image_url($id, 'large'),
            'alt'   => get_post_meta($id, '_wp_attachment_image_alt', true),
            'sizes' => [
                'large'     => wp_get_attachment_image_url($id, 'large'),
                'medium'    => wp_get_attachment_image_url($id, 'medium'),
                'thumbnail' => wp_get_attachment_image_url($id, 'thumbnail'),
            ],
        ], $ids);
    }
}

if (! function_exists('qazaqstan_transliterate')) {
    function qazaqstan_transliterate(string $text): string
    {
        $map = [
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'e',
            'ж' => 'zh', 'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm',
            'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u',
            'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch', 'ъ' => '',
            'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
            'ә' => 'a', 'ғ' => 'g', 'қ' => 'k', 'ң' => 'n', 'ө' => 'o', 'ұ' => 'u', 'ү' => 'u',
            'і' => 'i', 'һ' => 'h',
        ];

        $slug = sanitize_title_with_dashes(strtr(mb_strtolower($text), $map));

        return $slug !== '' ? $slug : 'n-' . substr(md5($text), 0, 8);
    }
}
