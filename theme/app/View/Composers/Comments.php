<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Comments extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'partials.comments',
    ];

    /**
     * The comment title.
     */
    public function title(): string
    {
        return sprintf(
            /* translators: %1$s is replaced with the number of comments and %2$s with the post title */
            _nx('%1$s комментарий к «%2$s»', '%1$s комментариев к «%2$s»', get_comments_number(), 'comments title', 'qazaqstan'),
            number_format_i18n(get_comments_number()),
            get_the_title()
        );
    }

    /**
     * Retrieve the comments.
     */
    public function responses(): ?string
    {
        if (! have_comments()) {
            return null;
        }

        return wp_list_comments([
            'style' => 'ol',
            'short_ping' => true,
            'echo' => false,
        ]);
    }

    /**
     * The previous comments link.
     */
    public function previous(): ?string
    {
        if (! get_previous_comments_link()) {
            return null;
        }

        return get_previous_comments_link(
            __('&larr; Предыдущие комментарии', 'qazaqstan')
        );
    }

    /**
     * The next comments link.
     */
    public function next(): ?string
    {
        if (! get_next_comments_link()) {
            return null;
        }

        return get_next_comments_link(
            __('Следующие комментарии &rarr;', 'qazaqstan')
        );
    }

    /**
     * Determine if the comments are paginated.
     */
    public function paginated(): bool
    {
        return get_comment_pages_count() > 1 && get_option('page_comments');
    }

    /**
     * Determine if the comments are closed.
     */
    public function closed(): bool
    {
        return ! comments_open() && get_comments_number() != '0' && post_type_supports(get_post_type(), 'comments');
    }

    /**
     * Arguments for comment_form(), russified and styled to match site forms.
     */
    public function formArgs(): array
    {
        return [
            'title_reply'          => __('Оставить комментарий', 'qazaqstan'),
            'title_reply_to'       => __('Ответить %s', 'qazaqstan'),
            'cancel_reply_link'    => __('Отменить ответ', 'qazaqstan'),
            'label_submit'         => __('Отправить', 'qazaqstan'),
            'comment_notes_before' => '',
            'comment_notes_after'  => '',
            'class_form'           => 'contact-form mt-6',
            'class_submit'         => 'btn btn--primary mt-2',
            'fields'               => [
                'author' => '<div class="contact-form__row"><div class="contact-form__field"><label for="author" class="contact-form__label">'
                    . __('Имя', 'qazaqstan') . ' <span aria-hidden="true">*</span></label>'
                    . '<input id="author" name="author" type="text" class="contact-form__input" autocomplete="name" required></div>',
                'email'  => '<div class="contact-form__field"><label for="email" class="contact-form__label">Email <span aria-hidden="true">*</span></label>'
                    . '<input id="email" name="email" type="email" class="contact-form__input" autocomplete="email" required></div></div>',
            ],
            'comment_field' => '<div class="contact-form__field"><label for="comment" class="contact-form__label">'
                . __('Комментарий', 'qazaqstan') . ' <span aria-hidden="true">*</span></label>'
                . '<textarea id="comment" name="comment" class="contact-form__textarea" rows="5" required></textarea></div>',
        ];
    }
}
