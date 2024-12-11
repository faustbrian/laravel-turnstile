<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\Turnstile\Rules;

use BaseCodeOy\Turnstile\Client;
use BaseCodeOy\Turnstile\ErrorMessage;
use Illuminate\Contracts\Validation\ValidationRule;

final readonly class Turnstile implements ValidationRule
{
    public function __construct(
        private Client $client,
    ) {
        //
    }

    #[\Override()]
    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        $errors = $this->client->verify($value);

        foreach ($errors as $error) {
            $fail(ErrorMessage::match($error));
        }
    }
}
