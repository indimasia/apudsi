<?php

namespace App\Filament\Resources\PrayArticleResource\Pages;

use App\Filament\Resources\PrayArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePrayArticle extends CreateRecord
{
    protected static string $resource = PrayArticleResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
