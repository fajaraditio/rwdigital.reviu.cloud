<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WargaResource\Pages;
use App\Models\User;
use Filament\Resources\Resource;

class WargaResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'phosphor-address-book-tabs';

    protected static ?string $navigationGroup = 'Pengelolaan Warga';

    protected static ?string $navigationLabel = 'Data Warga';

    protected static ?string $modelLabel = 'Data Warga';

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWarga::route('/'),
            'create' => Pages\CreateWarga::route('/create'),
            'edit' => Pages\EditWarga::route('/{record}/edit'),
        ];
    }
}
