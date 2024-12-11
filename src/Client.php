<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\Turnstile;

use Illuminate\Support\Facades\Http;

final readonly class Client
{
    public function __construct(
        private string $secret,
    ) {
        //
    }

    public function verify(string $response): array
    {
        $response = Http::retry(3, 100)
            ->asForm()
            ->acceptJson()
            ->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                'secret' => $this->secret,
                'response' => $response,
            ]);

        if ($response->ok()) {
            return $response->json('error-codes');
        }

        return ['internal-error'];
    }
}
