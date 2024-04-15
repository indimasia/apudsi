<?php

namespace App\Filament\Resources\BiroArticleResource\Pages;

use App\Filament\Resources\BiroArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBiroArticle extends CreateRecord
{
    protected static string $resource = BiroArticleResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
