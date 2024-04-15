<?php

namespace App\Filament\Resources\TipsArticleResource\Pages;

use App\Filament\Resources\TipsArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTipsArticle extends CreateRecord
{
    protected static string $resource = TipsArticleResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
