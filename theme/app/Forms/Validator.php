<?php

namespace App\Forms;

class Validator
{
    private array $errors = [];
    private array $data   = [];

    public function __construct(array $input)
    {
        $this->data = $input;
    }

    public function required(string $field, string $label): static
    {
        if (empty(trim((string) ($this->data[$field] ?? '')))) {
            $this->errors[$field] = sprintf(__('Поле «%s» обязательно для заполнения.', 'qazaqstan'), $label);
        }
        return $this;
    }

    public function phone(string $field): static
    {
        $val = preg_replace('/\D/', '', (string) ($this->data[$field] ?? ''));
        if (!empty($val) && (strlen($val) < 10 || strlen($val) > 15)) {
            $this->errors[$field] = __('Укажите корректный номер телефона.', 'qazaqstan');
        }
        return $this;
    }

    public function email(string $field): static
    {
        $val = trim((string) ($this->data[$field] ?? ''));
        if (!empty($val) && !is_email($val)) {
            $this->errors[$field] = __('Укажите корректный email-адрес.', 'qazaqstan');
        }
        return $this;
    }

    public function maxLength(string $field, int $max): static
    {
        $val = (string) ($this->data[$field] ?? '');
        if (mb_strlen($val) > $max) {
            $this->errors[$field] = sprintf(__('Поле не должно превышать %d символов.', 'qazaqstan'), $max);
        }
        return $this;
    }

    public function passes(): bool
    {
        return empty($this->errors);
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function get(string $field): string
    {
        return sanitize_text_field((string) ($this->data[$field] ?? ''));
    }

    public function textarea(string $field): string
    {
        return sanitize_textarea_field((string) ($this->data[$field] ?? ''));
    }

    public function int(string $field): int
    {
        return (int) ($this->data[$field] ?? 0);
    }

    public function email_value(string $field): string
    {
        return sanitize_email((string) ($this->data[$field] ?? ''));
    }
}
