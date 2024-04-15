<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestimonyResource\Pages;
use App\Filament\Resources\TestimonyResource\RelationManagers;
use App\Models\Testimony;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TestimonyResource extends Resource
{
    protected static ?string $model = Testimony::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('photo')
                    ->label("Foto")
                    ->image()
                    ->avatar()
                    ->nullable(),
                TextInput::make('name')
                    ->label("Nama")
                    ->required(),
                Textarea::make('content')
                    ->label("Testimoni")
                    ->required(),
                FileUpload::make('image')
                    ->label("Gambar")
                    ->image()
                    ->required(),
                TextInput::make('link')
                    ->label("Link"),
                Select::make('status')
                    ->label("Status")
                    ->options([
                        'published' => 'Published',
                        'draft' => 'Draft',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo')
                    ->label("Foto")
                    ->circular()
                    ->size(100),
                TextColumn::make('name')
                    ->label("Nama")
                    ->searchable()
                    ->sortable(),
                TextColumn::make('content')
                    ->label("Testimoni")
                    ->searchable()
                    ->sortable(),
                ImageColumn::make('image')
                    ->label("Gambar")
                    ->size(100),
                TextColumn::make('link')
                    ->label("Link")
                    ->searchable()
                    ->sortable(),
                SelectColumn::make('status')
                    ->label("Status")
                    ->options([
                        'published' => 'Published',
                        'draft' => 'Draft',
                    ])
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label("Status")
                    ->options([
                        'published' => 'Published',
                        'draft' => 'Draft',
                    ]),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageTestimonies::route('/'),
        ];
    }
}
