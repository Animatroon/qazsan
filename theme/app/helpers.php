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
            return get_field($key, 'option');
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
