<?php

namespace App\Filament\Resources\CulinaryArticleResource\Pages;

use App\Filament\Resources\CulinaryArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCulinaryArticle extends CreateRecord
{
    protected static string $resource = CulinaryArticleResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
