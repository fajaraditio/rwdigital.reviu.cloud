<?php

namespace App\Filament\Resources\RTAreaResource\Pages;

use App\Filament\Resources\RTAreaResource;
use Dotswan\MapPicker\Fields\Map;
use Filament\Actions;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;

class EditRTArea extends EditRecord
{
    protected static string $resource = RTAreaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Informasi Rukun Tetangga')
                ->description('Masukkan informasi mengenai nama dan lokasi rukun tetangga')
                ->schema([
                    TextInput::make('name')
                        ->label('Nama RT')
                        ->unique(ignoreRecord: true)
                        ->required(),

                    Grid::make()->columnSpan(1),

                    Textarea::make('address')
                        ->label('Alamat Lengkap')
                        ->rows(6)
                        ->required(),

                    Grid::make()->columnSpan(1),

                    Hidden::make('latitude'),

                    Hidden::make('longitude'),

                    Hidden::make('google_maps'),

                    Map::make('location')
                        ->label('Maps')
                        ->defaultLocation(latitude: -6.205979, longitude: 106.756135)
                        ->showMarker()
                        ->markerColor("#004A7C")
                        ->markerIconAnchor([18, 36])
                        ->markerIconSize([36, 36])
                        ->columnSpanFull()
                        ->zoom(18)
                        ->draggable()
                        ->extraStyles([
                            'min-height: 40vh',
                            'border-radius: 5px'
                        ])
                        ->afterStateUpdated(function ($set, ?array $state): void {
                            $set('latitude', $state['lat']);
                            $set('longitude', $state['lng']);
                            $set('google_maps', 'https://www.openstreetmap.org/#map=18/' . $state['lat'] . '/' . $state['lng']);
                        })
                        ->afterStateHydrated(function ($set, $record): void {
                            $set('location', [
                                'lat' => $record->latitude,
                                'lng' => $record->longitude,
                            ]);
                        })
                ])
                ->columns(2)
        ]);
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        unset($data['location']);

        return $data;
    }
}
