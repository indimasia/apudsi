<?php

namespace App\Filament\Pages;

use App\Settings\GeneralSettings;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Pages\SettingsPage;

class GeneralSetting extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $settings = GeneralSettings::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()
                    ->schema([
                        TextInput::make("mobile_version")
                            ->label("Mobile Version"),
                        Textarea::make("notify_registration_email_list")
                            ->rows(3)
                            ->label("Notify Registration Email List")
                            ->helperText("Separate with comma, dont use space.")
                            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('notify_registration_email_list', str_replace(' ', '', $state)))
                            ->live(onBlur: true),
                    ])
                    ->columns(1)
                    ->maxWidth('xl'),
            ]);
    }

    public function mutateFormDataBeforeSave(array $data): array
    {
        $data['notify_registration_email_list'] = str_replace(' ', '', $data['notify_registration_email_list']);
        return $data;
    }
}
