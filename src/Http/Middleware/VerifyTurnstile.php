<?php

declare(strict_types=1);

namespace PreemStudio\Turnstile\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use PreemStudio\Turnstile\Client;
use PreemStudio\Turnstile\ErrorMessage;
use Symfony\Component\HttpFoundation\Response;

class VerifyTurnstile
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
