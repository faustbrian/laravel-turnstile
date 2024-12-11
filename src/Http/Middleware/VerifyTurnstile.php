<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\Turnstile\Http\Middleware;

use BaseCodeOy\Turnstile\Client;
use BaseCodeOy\Turnstile\ErrorMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class VerifyTurnstile
{
    public function handle(Request $request, \Closure $next): Response|RedirectResponse
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
