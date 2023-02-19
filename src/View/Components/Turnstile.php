<?php

declare(strict_types=1);

namespace PreemStudio\Turnstile\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Turnstile extends Component
{
    public function render(): View
    {
        return view('laravel-turnstile::components.turnstile');
    }
}
