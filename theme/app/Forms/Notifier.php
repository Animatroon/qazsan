<?php

namespace App\Forms;

class Notifier
{
    public static function send(string $subject, string $body, ?string $replyTo = null): bool
    {
        $adminEmail = get_option('admin_email');
        $notifyEmail = get_option('qazaqstan_notify_email') ?: $adminEmail;

        $headers = ['Content-Type: text/html; charset=UTF-8'];
        if ($replyTo && is_email($replyTo)) {
            $headers[] = 'Reply-To: ' . $replyTo;
        }

        $html = sprintf(
            '<html><body style="font-family:Arial,sans-serif;font-size:15px;color:#2A2D2B;padding:20px;">
            <div style="max-width:600px;margin:0 auto;border:1px solid #E5E7E2;border-radius:12px;overflow:hidden;">
              <div style="background:#3872B8;padding:20px 28px;">
                <p style="color:#fff;font-weight:700;font-size:18px;margin:0;">QAZAQSTAN Resort</p>
              </div>
              <div style="padding:28px;">%s</div>
              <div style="background:#F8F9F6;padding:16px 28px;border-top:1px solid #E5E7E2;">
                <p style="color:#6B6E6A;font-size:13px;margin:0;">%s · %s</p>
              </div>
            </div></body></html>',
            $body,
            esc_html(get_bloginfo('name')),
            esc_html(current_time('d.m.Y H:i'))
        );

        return wp_mail($notifyEmail, '[QAZAQSTAN] ' . $subject, $html, $headers);
    }

    public static function row(string $label, string $value): string
    {
        return sprintf(
            '<p style="margin:6px 0;"><strong>%s:</strong> %s</p>',
            esc_html($label),
            esc_html($value)
        );
    }
}
