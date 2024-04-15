<?php

namespace App\Filament\Resources\BiroResource\Pages;

use App\Filament\Resources\BiroResource;
use App\Models\Biro;
use Filament\Actions;
use Filament\Forms\Form;
use Filament\Resources\Pages\ManageRecords;

class ManageBiros extends ManageRecords
{
    protected static string $resource = BiroResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->after(function(Biro $biro) {
                    $admin = $biro->allUsers->first();
                    $admin->assignRole('biro');
                    $admin->is_active = $biro->is_active;
                    $admin->save();
                }),
        ];
    }
}
