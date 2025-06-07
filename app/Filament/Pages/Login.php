<?php

namespace App\Filament\Pages;

use Filament\Pages\Auth\Login as AuthLogin;
use Filament\Pages\Page;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Contracts\Support\Htmlable;

class Login extends AuthLogin
{
    public function getHeading(): string|Htmlable
    {
        return 'Single Sign-On';
    }

    public function getSubheading(): string|Htmlable|null
    {
        return 'Silakan masuk dengan akun dan kata sandi Anda';
    }

    public function getMaxWidth(): MaxWidth|string|null
    {
        return MaxWidth::Small;
    }
}
