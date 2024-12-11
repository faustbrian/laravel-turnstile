<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\Turnstile;

use BaseCodeOy\Crate\Package\AbstractServiceProvider;
use BaseCodeOy\Turnstile\Rules\Turnstile;
use BaseCodeOy\Turnstile\View\Components\Turnstile as TurnstileComponent;
use Illuminate\Support\Facades\Blade;
use Illuminate\Validation\Rule;

final class ServiceProvider extends AbstractServiceProvider
{
    #[\Override()]
    public function packageRegistered(): void
    {
        $this->app->singleton(Client::class, fn ($app): \BaseCodeOy\Turnstile\Client => new Client($app['config']->get('services.turnstile.secret')));
    }

    #[\Override()]
    public function packageBooted(): void
    {
        Blade::component(
            'turnstile',
            TurnstileComponent::class,
        );

        Blade::directive(
            'turnstileScripts',
            fn (): string => '<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>',
        );

        Rule::macro(
            'turnstile',
            fn () => $this->app->make(Turnstile::class),
        );
    }
}
