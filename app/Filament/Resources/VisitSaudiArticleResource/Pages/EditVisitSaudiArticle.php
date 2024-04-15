<?php

namespace App\Filament\Resources\VisitSaudiArticleResource\Pages;

use App\Filament\Resources\VisitSaudiArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVisitSaudiArticle extends EditRecord
{
    protected static string $resource = VisitSaudiArticleResource::class;

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
