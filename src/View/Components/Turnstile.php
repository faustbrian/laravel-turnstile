<?php

declare(strict_types=1);

namespace BaseCodeOy\Turnstile\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

final class Turnstile extends Component
{
    public function render(): View
    {
        return view('laravel-turnstile::components.turnstile');
    }
}
