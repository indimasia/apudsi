<?php

namespace App\Filament\Resources\HiddenGemArticleResource\Pages;

use App\Filament\Resources\HiddenGemArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHiddenGemArticle extends EditRecord
{
    protected static string $resource = HiddenGemArticleResource::class;

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
