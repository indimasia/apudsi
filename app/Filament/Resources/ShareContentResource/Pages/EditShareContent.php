<?php

namespace App\Filament\Resources\ShareContentResource\Pages;

use App\Filament\Resources\ShareContentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditShareContent extends EditRecord
{
    protected static string $resource = ShareContentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
