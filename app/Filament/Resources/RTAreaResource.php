<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RTAreaResource\Pages;
use App\Filament\Resources\RTAreaResource\RelationManagers;
use App\Models\RTArea;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RTAreaResource extends Resource
{
    protected static ?string $model = RTArea::class;

    protected static ?string $navigationIcon = 'phosphor-map-pin-area';

    protected static ?string $navigationGroup = 'Rukun Tetangga';

    protected static ?string $navigationLabel = 'Daftar RT';

    protected static ?string $modelLabel = 'Daftar';

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRTAreas::route('/'),
            'create' => Pages\CreateRTArea::route('/create'),
            'edit' => Pages\EditRTArea::route('/{record}/edit'),
        ];
    }
}
