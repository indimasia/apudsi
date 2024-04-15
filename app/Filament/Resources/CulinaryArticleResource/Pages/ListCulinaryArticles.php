<?php

namespace App\Filament\Resources\CulinaryArticleResource\Pages;

use App\Filament\Resources\CulinaryArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCulinaryArticles extends ListRecords
{
    protected static string $resource = CulinaryArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
