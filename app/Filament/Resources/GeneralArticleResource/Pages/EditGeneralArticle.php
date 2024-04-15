<?php

namespace App\Filament\Resources\GeneralArticleResource\Pages;

use App\Filament\Resources\GeneralArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGeneralArticle extends EditRecord
{
    protected static string $resource = GeneralArticleResource::class;

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
