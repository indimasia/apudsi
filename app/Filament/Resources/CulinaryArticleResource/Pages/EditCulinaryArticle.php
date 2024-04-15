<?php

namespace App\Filament\Resources\CulinaryArticleResource\Pages;

use App\Filament\Resources\CulinaryArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCulinaryArticle extends EditRecord
{
    protected static string $resource = CulinaryArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
