<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmergencyResource\Pages;
use App\Filament\Resources\EmergencyResource\RelationManagers;
use App\Models\Emergency;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmergencyResource extends Resource
{
    protected static ?string $model = Emergency::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label('Nama')
                    ->required(),
                TextInput::make('content')
                    ->label('phone')
                    ->required(),
                Select::make("status")
                    ->label("Status")
                    ->options([
                        "draft" => "Draft",
                        "published" => "Published",
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label("Nama")
                    ->searchable()
                    ->sortable(),
                TextColumn::make('content')
                    ->label("phone")
                    ->searchable()
                    ->sortable(),
                SelectColumn::make('status')
                    ->label('Status')
                    ->rules(['required'])
                    ->options([
                        "draft" => "Draft",
                        "published" => "Published",
                    ]),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                    ])
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmergencies::route('/'),
            'create' => Pages\CreateEmergency::route('/create'),
            'edit' => Pages\EditEmergency::route('/{record}/edit'),
        ];
    }
}
