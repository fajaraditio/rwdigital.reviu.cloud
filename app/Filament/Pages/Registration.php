<?php

namespace App\Filament\Pages;

use App\Constants\UserDetailConstant;
use App\Models\RTArea;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Pages\Auth\Register;
use Filament\Pages\Page;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Database\Eloquent\Model;
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
                                    $this->getNameFormComponent()->columnSpanFull(),
                                    $this->getEmailFormComponent(),
                                    $this->getPhoneNumberComponent(),
                                    $this->getGenderFormComponent(),
                                    Grid::make(),
                                    $this->getPlaceOfBirthFormComponent(),
                                    $this->getDateOfBirthFormComponent(),
                                ])
                                ->columns(2),
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

    protected function getNameFormComponent(): Component
    {
        return TextInput::make('name')
            ->label('Nama Lengkap')
            ->required()
            ->maxLength(255)
            ->placeholder('Contoh: Ainun')
            ->autofocus();
    }

    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('email')
            ->label('Alamat Email')
            ->email()
            ->required()
            ->maxLength(255)
            ->placeholder('Contoh: ainun@rwdigital.test')
            ->unique($this->getUserModel());
    }

    protected function getRoleComponent(): Component
    {
        return Hidden::make('role')->default('warga');
    }

    protected function getRTAreaFormComponent(): Component
    {
        return Select::make('detail.rt_area_id')
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
            ->placeholder('Contoh: 3172 0010 0011 0012')
            ->autofocus();
    }

    protected function getPhoneNumberComponent(): Component
    {
        return TextInput::make('phone_number')
            ->label('Nomor Telepon')
            ->required()
            ->mask('9999 9999 9999 99')
            ->placeholder('Contoh: 0831 3123 4321 2314')
            ->mutateDehydratedStateUsing(fn($state) => str($state)->replace(' ', ''));
    }

    protected function getGenderFormComponent(): Component
    {
        return Select::make('detail.gender')
            ->label('Jenis Kelamin')
            ->options(UserDetailConstant::GENDER_LABELS)
            ->required();
    }

    protected function getPlaceOfBirthFormComponent(): Component
    {
        return TextInput::make('detail.place_of_birth')
            ->label('Tempat Lahir')
            ->placeholder('Contoh: Jakarta');
    }

    protected function getDateOfBirthFormComponent(): Component
    {
        return DatePicker::make('detail.date_of_birth')
            ->label('Tanggal Lahir')
            ->displayFormat('j F Y')
            ->placeholder('Contoh: 11 November 1990')
            ->label('Jenis Kelamin');
    }

    protected function handleRegistration(array $data): Model
    {
        $detail = $data['detail'];

        unset($data['detail']);

        $user = User::create($data);

        $user->detail()->create($detail);

        return $user;
    }
}
