<?php

namespace App\Filament\Resources\BiroArticleResource\Pages;

use App\Filament\Resources\BiroArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBiroArticles extends ListRecords
{
    protected static string $resource = BiroArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
