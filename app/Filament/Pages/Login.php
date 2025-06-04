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
        return 'SSO - RW Digital';
    }

    public function getMaxWidth(): MaxWidth|string|null
    {
        return MaxWidth::Medium;
    }
}
