<?php

namespace App\Filament\Pages;

use App\Models\RTArea;
use Filament\Actions\Action;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Pages\Auth\Register;
use Filament\Pages\Page;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;

class Registration extends Register
{
    public function getMaxWidth(): MaxWidth|string|null
    {
        return MaxWidth::ScreenMedium;
    }

    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        Wizard::make([
                            Wizard\Step::make('Daftar NIK dan RT')
                                ->schema([
                                    $this->getRTAreaFormComponent(),
                                    $this->getNikFormComponent(),
                                ]),
                            Wizard\Step::make('Data Pribadi')
                                ->schema([
                                    $this->getNameFormComponent(),
                                    $this->getEmailFormComponent(),
                                    $this->getPhoneNumberComponent(),
                                ]),
                            Wizard\Step::make('Keamanan Akun')
                                ->schema([
                                    $this->getPasswordFormComponent(),
                                    $this->getPasswordConfirmationFormComponent(),
                                ])
                        ])
                            ->submitAction(new HtmlString(Blade::render(<<<BLADE
                                 <x-filament::button type="submit" size="sm">
                                        {{ __('filament-panels::pages/auth/register.form.actions.register.label') }}
                                    </x-filament::button>
                                BLADE))),
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
            ->options(RTArea::all()->pluck('name', 'id'))
            ->native(false)
            ->searchable()
            ->getSearchResultsUsing(fn(string $search): array => RTArea::where('name', 'like', "%{$search}%")->limit(10)->pluck('name', 'id')->toArray())
            ->getOptionLabelsUsing(fn(array $values): array => RTArea::whereIn('id', $values)->pluck('name', 'id')->toArray())
            ->required();
    }

    protected function getNikFormComponent(): Component
    {
        return TextInput::make('nik')
            ->label('Nomor Induk Kependudukan (NIK)')
            ->required()
            ->mask('9999 9999 9999 9999')
            ->mutateDehydratedStateUsing(fn($state) => str($state)->replace(' ', ''))
            ->autofocus();
    }

    protected function getPhoneNumberComponent(): Component
    {
        return TextInput::make('phone_number')
            ->label('Nomor Telepon')
            ->required()
            ->mask('9999 9999 9999 99')
            ->mutateDehydratedStateUsing(fn($state) => str($state)->replace(' ', ''));
    }
}
