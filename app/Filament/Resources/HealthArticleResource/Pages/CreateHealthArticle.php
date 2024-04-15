<?php

namespace App\Filament\Resources\HealthArticleResource\Pages;

use App\Filament\Resources\HealthArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateHealthArticle extends CreateRecord
{
    protected static string $resource = HealthArticleResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
