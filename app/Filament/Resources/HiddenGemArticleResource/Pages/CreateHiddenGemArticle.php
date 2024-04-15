<?php

namespace App\Filament\Resources\HiddenGemArticleResource\Pages;

use App\Filament\Resources\HiddenGemArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateHiddenGemArticle extends CreateRecord
{
    protected static string $resource = HiddenGemArticleResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
