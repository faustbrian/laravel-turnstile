<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\Turnstile\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

final class Turnstile extends Component
{
    #[\Override()]
    public function render(): View
    {
        return view('turnstile::components.turnstile');
    }
}
