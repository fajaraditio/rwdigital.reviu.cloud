<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Auth\Register;
use Filament\Pages\Page;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\HtmlString;

class Registration extends Register
{
    public function getMaxWidth(): MaxWidth|string|null
    {
        return MaxWidth::Medium;
    }

    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getNikFormComponent(),
                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent(),
                        $this->getPhoneNumberComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    protected function getRoleComponent(): Component
    {
        return Hidden::make('role')->default('warga');
    }

    protected function getRTAreaFormComponent(): Component
    {
        return Select::make('rt_area_id')
            ->label('Rukun Tetangga')
            ->required()
            ->mask('9999 9999 9999 9999')
            ->mutateDehydratedStateUsing(fn($state) => (int) $state)
            ->autofocus();
    }

    protected function getNikFormComponent(): Component
    {
        return TextInput::make('nik')
            ->label('Nomor Induk Kependudukan (NIK)')
            ->required()
            ->mask('9999 9999 9999 9999')
            ->mutateDehydratedStateUsing(fn($state) => (int) $state)
            ->autofocus();
    }

    protected function getPhoneNumberComponent(): Component
    {
        return TextInput::make('phone_number')
            ->label('Nomor Telepon')
            ->required()
            ->mask('9999 9999 9999 99')
            ->mutateDehydratedStateUsing(fn($state) => (int) $state)
            ->autofocus();
    }

    public function getRegisterFormAction(): Action
    {
        return Action::make('register')
            ->requiresConfirmation()
            ->modalDescription(new HtmlString('Apakah data yang Anda input sudah benar?'))
            ->label(__('filament-panels::pages/auth/register.form.actions.register.label'))
            ->action('register');
    }
}
