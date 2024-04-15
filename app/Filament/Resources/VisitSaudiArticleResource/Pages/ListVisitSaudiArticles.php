<?php

namespace App\Filament\Resources\VisitSaudiArticleResource\Pages;

use App\Filament\Resources\VisitSaudiArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVisitSaudiArticles extends ListRecords
{
    protected static string $resource = VisitSaudiArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
