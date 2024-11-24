<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\Turnstile;

final class ErrorMessage
{
    public static function match(string $error): string
    {
        return match ($error) {
            'missing-input-secret' => trans('laravel-turnstile::errors.missing-input-secret'),
            'invalid-input-secret' => trans('laravel-turnstile::errors.invalid-input-secret'),
            'missing-input-response' => trans('laravel-turnstile::errors.missing-input-response'),
            'invalid-input-response' => trans('laravel-turnstile::errors.invalid-input-response'),
            'bad-request' => trans('laravel-turnstile::errors.bad-request'),
            'timeout-or-duplicate' => trans('laravel-turnstile::errors.timeout-or-duplicate'),
            'internal-error' => trans('laravel-turnstile::errors.internal-error'),
            default => trans('laravel-turnstile::errors.default'),
        };
    }
}
