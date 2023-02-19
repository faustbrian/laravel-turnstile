<?php

declare(strict_types=1);

namespace PreemStudio\Turnstile;

use Illuminate\Support\Facades\Blade;
use Illuminate\Validation\Rule;
use PreemStudio\Turnstile\Rules\Turnstile;
use PreemStudio\Turnstile\View\Components\Turnstile as TurnstileComponent;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-turnstile')
            ->hasTranslations('laravel-turnstile')
            ->hasViews('laravel-turnstile');
    }

    public function packageRegistered()
    {
        $this->app->singleton(Client::class, fn ($app) => new Client($app['config']->get('services.turnstile.secret')));
    }

    public function packageBooted()
    {
        Blade::component('turnstile', TurnstileComponent::class);

        Blade::directive('turnstileScripts', fn () => '<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>');

        Rule::macro('turnstile', fn () => $this->app->make(Turnstile::class));
    }
}
