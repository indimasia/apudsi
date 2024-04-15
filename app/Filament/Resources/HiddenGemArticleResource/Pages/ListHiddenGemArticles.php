<?php

namespace App\Filament\Resources\HiddenGemArticleResource\Pages;

use App\Filament\Resources\HiddenGemArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHiddenGemArticles extends ListRecords
{
    protected static string $resource = HiddenGemArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
