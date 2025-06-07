<?php

namespace App\Filament\Resources\RTAreaResource\Pages;

use App\Filament\Resources\RTAreaResource;
use Filament\Actions;
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
}
