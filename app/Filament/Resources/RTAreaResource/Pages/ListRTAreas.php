<?php

namespace App\Filament\Resources\RTAreaResource\Pages;

use App\Filament\Resources\RTAreaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Table;

class ListRTAreas extends ListRecords
{
    protected static string $resource = RTAreaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('RT'),

                TextColumn::make('users_count')
                    ->label('Jumlah Warga')
                    ->counts('users'),

                TextColumn::make('address')
                    ->label('Alamat Lengkap'),

                TextColumn::make('latitude')
                    ->label('Alamat Lengkap'),

                TextColumn::make('longitude')
                    ->label('Alamat Lengkap'),
            ])
            ->actions([
                EditAction::make()
                    ->button(),
                DeleteAction::make()
                    ->button(),
            ]);
    }
}
