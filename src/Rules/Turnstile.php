<?php

declare(strict_types=1);

namespace BombenProdukt\Turnstile\Rules;

use BombenProdukt\Turnstile\Client;
use BombenProdukt\Turnstile\ErrorMessage;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

final class Turnstile implements ValidationRule
{
    public function __construct(private Client $turnstile)
    {
        //
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $errors = $this->turnstile->verify($value);

        foreach ($errors as $error) {
            $fail(ErrorMessage::match($error));
        }
    }
}
