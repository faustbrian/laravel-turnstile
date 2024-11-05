<?php

declare(strict_types=1);

namespace BaseCodeOy\Turnstile;

use Illuminate\Support\Facades\Http;

final class Client
{
    public function __construct(private string $secret)
    {
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
