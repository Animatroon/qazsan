<?php

namespace App\Admin;

class Columns
{
    public static function register(): void
    {
        self::bookingColumns();
        self::appealColumns();
    }

    private static function bookingColumns(): void
    {
        add_filter('manage_booking_request_posts_columns', function (array $cols): array {
            unset($cols['date']);
            return array_merge($cols, [
                'br_name'     => __('Гость', 'qazaqstan'),
                'br_phone'    => __('Телефон', 'qazaqstan'),
                'br_checkin'  => __('Заезд', 'qazaqstan'),
                'br_checkout' => __('Выезд', 'qazaqstan'),
                'br_room'     => __('Номер', 'qazaqstan'),
                'br_status'   => __('Статус', 'qazaqstan'),
                'date'        => __('Дата заявки', 'qazaqstan'),
            ]);
        });

        add_action('manage_booking_request_posts_custom_column', function (string $col, int $postId): void {
            $statusColors = [
                'new'        => '#3872B8',
                'processing' => '#FFDE59',
                'confirmed'  => '#5E9340',
                'cancelled'  => '#dc2626',
            ];
            $statusLabels = [
                'new'        => __('Новая', 'qazaqstan'),
                'processing' => __('В работе', 'qazaqstan'),
                'confirmed'  => __('Подтверждена', 'qazaqstan'),
                'cancelled'  => __('Отменена', 'qazaqstan'),
            ];
            $val = function_exists('get_field') ? get_field($col, $postId) : get_post_meta($postId, $col, true);
            switch ($col) {
                case 'br_name':
                    echo esc_html((string) $val);
                    break;
                case 'br_phone':
                    printf('<a href="tel:%s">%s</a>', esc_attr(preg_replace('/\D/', '', (string) $val)), esc_html((string) $val));
                    break;
                case 'br_checkin':
                case 'br_checkout':
                    echo esc_html((string) $val);
                    break;
                case 'br_room':
                    $roomType = function_exists('get_field') ? get_field('br_room_type', $postId) : get_post_meta($postId, 'br_room_type', true);
                    echo esc_html((string) $roomType);
                    break;
                case 'br_status':
                    $status = (string) $val ?: 'new';
                    $color  = $statusColors[$status] ?? '#6B6E6A';
                    $label  = $statusLabels[$status] ?? $status;
                    printf('<span style="display:inline-block;padding:2px 10px;border-radius:9999px;background:%s;color:#fff;font-size:12px;font-weight:700;">%s</span>',
                        esc_attr($color), esc_html($label));
                    break;
            }
        }, 10, 2);
    }

    private static function appealColumns(): void
    {
        add_filter('manage_appeal_posts_columns', function (array $cols): array {
            unset($cols['date']);
            return array_merge($cols, [
                'appeal_type'   => __('Тип', 'qazaqstan'),
                'appeal_name'   => __('Заявитель', 'qazaqstan'),
                'appeal_phone'  => __('Контакт', 'qazaqstan'),
                'appeal_status' => __('Статус', 'qazaqstan'),
                'date'          => __('Дата', 'qazaqstan'),
            ]);
        });

        add_action('manage_appeal_posts_custom_column', function (string $col, int $postId): void {
            $get = fn($k) => function_exists('get_field') ? get_field($k, $postId) : get_post_meta($postId, $k, true);
            $typeLabels = [
                'general'    => __('Общий', 'qazaqstan'),
                'booking'    => __('Бронь', 'qazaqstan'),
                'complaint'  => __('Жалоба', 'qazaqstan'),
                'president'  => __('Президенту', 'qazaqstan'),
                'corruption' => __('Коррупция', 'qazaqstan'),
                'vacancy'    => __('Вакансия', 'qazaqstan'),
            ];
            switch ($col) {
                case 'appeal_type':
                    $type = (string) $get('appeal_type');
                    echo esc_html($typeLabels[$type] ?? $type);
                    break;
                case 'appeal_name':
                    echo esc_html((string) $get('appeal_name'));
                    break;
                case 'appeal_phone':
                    $phone = (string) $get('appeal_phone');
                    $email = (string) $get('appeal_email');
                    if ($phone) printf('<a href="tel:%s">%s</a>', esc_attr(preg_replace('/\D/', '', $phone)), esc_html($phone));
                    if ($email) printf('<br><a href="mailto:%s">%s</a>', esc_attr($email), esc_html($email));
                    break;
                case 'appeal_status':
                    $status = (string) $get('appeal_status') ?: 'new';
                    $colors = ['new' => '#3872B8', 'in_progress' => '#FFDE59', 'closed' => '#5E9340'];
                    $labels = ['new' => __('Новое', 'qazaqstan'), 'in_progress' => __('В работе', 'qazaqstan'), 'closed' => __('Закрыто', 'qazaqstan')];
                    printf('<span style="display:inline-block;padding:2px 10px;border-radius:9999px;background:%s;color:#fff;font-size:12px;font-weight:700;">%s</span>',
                        esc_attr($colors[$status] ?? '#6B6E6A'),
                        esc_html($labels[$status] ?? $status));
                    break;
            }
        }, 10, 2);
    }
}
