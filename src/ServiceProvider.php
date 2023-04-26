<?php

declare(strict_types=1);

namespace BombenProdukt\Turnstile;

use BombenProdukt\PackagePowerPack\Package\AbstractServiceProvider;
use BombenProdukt\Turnstile\Rules\Turnstile;
use BombenProdukt\Turnstile\View\Components\Turnstile as TurnstileComponent;
use Illuminate\Support\Facades\Blade;
use Illuminate\Validation\Rule;

final class ServiceProvider extends AbstractServiceProvider
{
    public function packageRegistered(): void
    {
        $this->app->singleton(Client::class, fn ($app) => new Client($app['config']->get('services.turnstile.secret')));
    }

    public function packageBooted(): void
    {
        Blade::component('turnstile', TurnstileComponent::class);

        Blade::directive('turnstileScripts', fn () => '<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>');

        Rule::macro('turnstile', fn () => $this->app->make(Turnstile::class));
    }
}
