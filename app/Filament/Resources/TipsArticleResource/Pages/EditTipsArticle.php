<?php

namespace App\Filament\Resources\TipsArticleResource\Pages;

use App\Filament\Resources\TipsArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTipsArticle extends EditRecord
{
    protected static string $resource = TipsArticleResource::class;

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
