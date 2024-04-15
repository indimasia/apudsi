<?php

namespace App\Filament\Resources\VisitSaudiArticleResource\Pages;

use App\Filament\Resources\VisitSaudiArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateVisitSaudiArticle extends CreateRecord
{
    protected static string $resource = VisitSaudiArticleResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
