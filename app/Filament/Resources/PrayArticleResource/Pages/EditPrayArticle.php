<?php

namespace App\Filament\Resources\PrayArticleResource\Pages;

use App\Filament\Resources\PrayArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPrayArticle extends EditRecord
{
    protected static string $resource = PrayArticleResource::class;

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
