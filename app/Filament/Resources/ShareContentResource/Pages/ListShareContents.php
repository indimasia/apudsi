<?php

namespace App\Filament\Resources\ShareContentResource\Pages;

use App\Filament\Resources\ShareContentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListShareContents extends ListRecords
{
    protected static string $resource = ShareContentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
