<?php

namespace App\Filament\Resources\GeneralArticleResource\Pages;

use App\Filament\Resources\GeneralArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateGeneralArticle extends CreateRecord
{
    protected static string $resource = GeneralArticleResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
