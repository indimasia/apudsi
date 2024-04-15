<?php

namespace App\Filament\Resources\HealthArticleResource\Pages;

use App\Filament\Resources\HealthArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHealthArticles extends ListRecords
{
    protected static string $resource = HealthArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
