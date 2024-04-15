<?php

namespace App\Filament\Resources\GeneralArticleResource\Pages;

use App\Filament\Resources\GeneralArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGeneralArticles extends ListRecords
{
    protected static string $resource = GeneralArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
