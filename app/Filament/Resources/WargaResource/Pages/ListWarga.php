<?php

namespace App\Filament\Resources\WargaResource\Pages;

use App\Constants\UserConstant;
use App\Filament\Resources\WargaResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ListWarga extends ListRecords
{
    protected static string $resource = WargaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all'           => Tab::make()->label('Semua'),
            'verified'      => Tab::make()->label('Terverifikasi')
                ->modifyQueryUsing(fn(Builder $query) => $query->whereNotNull('verified_at')),
            'unverified'    => Tab::make()->label('Belum Diverifikasi')
                ->modifyQueryUsing(fn(Builder $query) => $query->whereNull('verified_at')),
        ];
    }

    public function getDefaultActiveTab(): string | int | null
    {
        return 'verified';
    }

    public function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn($query) => $query->whereIn('role', [
                str(UserConstant::ROLE_WARGA)->lower(),
                str(UserConstant::ROLE_KETUA_RT)->lower()->snake()
            ]))
            ->columns([
                TextColumn::make('nik')
                    ->label('NIK')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('rt_area.name')
                    ->label('RT'),

                TextColumn::make('name')
                    ->label('Nama Warga')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('role')
                    ->label('Ketua RT / Warga')
                    ->badge()
                    ->formatStateUsing(function ($state) {
                        if ($state === str(UserConstant::ROLE_WARGA)->lower()->value()) return UserConstant::ROLE_WARGA;
                        if ($state === str(UserConstant::ROLE_KETUA_RT)->lower()->snake()->value()) return UserConstant::ROLE_KETUA_RT;
                    })
                    ->color(function ($state) {
                        if ($state === str(UserConstant::ROLE_WARGA)->lower()->value()) return 'info';
                        if ($state === str(UserConstant::ROLE_KETUA_RT)->lower()->snake()->value()) return 'success';
                    }),

                TextColumn::make('email')
                    ->label('Email Warga'),

                TextColumn::make('phone_number')
                    ->label('No. Telp Warga'),
            ])
            ->filters([
                SelectFilter::make('rt_area')
                    ->label('Pilih RT')
                    ->relationship('rt_area', 'name')
                    ->native(false)
                    ->searchable()
                    ->preload(),

            ], layout: FiltersLayout::AboveContent)
            ->actions([
                EditAction::make()
                    ->button(),
                DeleteAction::make()
                    ->button(),
            ]);
    }
}
