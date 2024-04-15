<?php

namespace App\Filament\Resources\TipsArticleResource\Pages;

use App\Filament\Resources\TipsArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTipsArticles extends ListRecords
{
    protected static string $resource = TipsArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
