<?php

namespace App\Filament\Resources\HealthArticleResource\Pages;

use App\Filament\Resources\HealthArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHealthArticle extends EditRecord
{
    protected static string $resource = HealthArticleResource::class;

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
