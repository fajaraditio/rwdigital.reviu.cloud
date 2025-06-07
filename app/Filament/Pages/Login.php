<?php

namespace App\Filament\Pages;

use Filament\Pages\Auth\Login as AuthLogin;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Contracts\Support\Htmlable;

class Login extends AuthLogin
{
    public function getHeading(): string|Htmlable
    {
        return 'Single Sign-On';
    }

    public function getMaxWidth(): MaxWidth|string|null
    {
        return MaxWidth::Medium;
    }
}
