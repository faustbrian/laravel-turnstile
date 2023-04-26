<?php

declare(strict_types=1);

namespace BombenProdukt\Turnstile\Http\Middleware;

use BombenProdukt\Turnstile\Client;
use BombenProdukt\Turnstile\ErrorMessage;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class VerifyTurnstile
{
    public function handle(Request $request, Closure $next): Response|RedirectResponse
    {
        $errors = app(Client::class)->verify($request->get('cf-turnstile-response'));

        if (empty($errors)) {
            return $next($request);
        }

        return redirect()
            ->back()
            ->with(key: 'status', value: ErrorMessage::match($errors[0]));
    }
}
