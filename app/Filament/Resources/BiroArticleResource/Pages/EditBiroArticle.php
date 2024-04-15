<?php

namespace App\Filament\Resources\BiroArticleResource\Pages;

use App\Filament\Resources\BiroArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBiroArticle extends EditRecord
{
    protected static string $resource = BiroArticleResource::class;

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
