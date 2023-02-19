<?php

declare(strict_types=1);

namespace PreemStudio\Turnstile\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use PreemStudio\Turnstile\Client;

class Turnstile implements ValidationRule
{
    public function __construct(private Client $turnstile)
    {
        //
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $errors = $this->turnstile->verify($value);

        foreach ($errors as $error) {
            $fail(match ($error) {
                'missing-input-secret'   => trans('laravel-turnstile::errors.missing-input-secret'),
                'invalid-input-secret'   => trans('laravel-turnstile::errors.invalid-input-secret'),
                'missing-input-response' => trans('laravel-turnstile::errors.missing-input-response'),
                'invalid-input-response' => trans('laravel-turnstile::errors.invalid-input-response'),
                'bad-request'            => trans('laravel-turnstile::errors.bad-request'),
                'timeout-or-duplicate'   => trans('laravel-turnstile::errors.timeout-or-duplicate'),
                'internal-error'         => trans('laravel-turnstile::errors.internal-error'),
                default                  => trans('laravel-turnstile::errors.default'),
            });
        }
    }
}
