<?php

declare(strict_types=1);

namespace PreemStudio\Turnstile;

use Illuminate\Support\Facades\Blade;
use Illuminate\Validation\Rule;
use PreemStudio\Turnstile\Rules\Turnstile;
use PreemStudio\Turnstile\View\Components\Turnstile as TurnstileComponent;
use PreemStudio\Jetpack\Package\AbstractServiceProvider;
use PreemStudio\Jetpack\Package\Package;

class ServiceProvider extends AbstractServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-turnstile')
            ->hasTranslations()
            ->hasViews('laravel-turnstile');
    }

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
