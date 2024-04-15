<?php

namespace App\Filament\Resources\PrayArticleResource\Pages;

use App\Filament\Resources\PrayArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPrayArticles extends ListRecords
{
    protected static string $resource = PrayArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
