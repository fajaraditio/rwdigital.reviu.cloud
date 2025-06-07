<?php

namespace App\Filament\Resources;

use App\Constants\UserConstant;
use App\Filament\Resources\WargaResource\Pages;
use App\Filament\Resources\WargaResource\RelationManagers;
use App\Models\RTArea;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WargaResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'phosphor-address-book-tabs';

    protected static ?string $navigationGroup = 'Pengelolaan Warga';

    protected static ?string $navigationLabel = 'Data Warga';

    protected static ?string $modelLabel = 'Data Warga';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn($query) => $query->where('role', str(UserConstant::ROLE_WARGA)->lower()))
            ->columns([
                TextColumn::make('nik')
                    ->label('NIK')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('name')
                    ->label('Nama Warga')
                    ->sortable()
                    ->searchable(),

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
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWargas::route('/'),
            'create' => Pages\CreateWarga::route('/create'),
            'edit' => Pages\EditWarga::route('/{record}/edit'),
        ];
    }
}
