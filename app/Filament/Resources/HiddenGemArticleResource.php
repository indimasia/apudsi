<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HiddenGemArticleResource\Pages;
use App\Filament\Resources\HiddenGemArticleResource\RelationManagers;
use App\Models\HiddenGemArticle;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class HiddenGemArticleResource extends Resource
{
    protected static ?string $model = HiddenGemArticle::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('thumbnail')
                    ->label('Thumbnail')
                    ->image()
                    ->required(),
                TextInput::make('title')
                    ->label('Title')
                    ->required()
                    ->live(true)
                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),
                TextInput::make('slug')
                    ->label('Slug')
                    ->required(),
                Select::make("status")
                    ->label("Status")
                    ->options([
                        "draft" => "Draft",
                        "published" => "Published",
                    ])
                    ->required(),
                Textarea::make('excerpt')
                    ->label('Excerpt'),
                Repeater::make('slideshows')
                    ->relationship()
                    ->required(false)
                    ->defaultItems(0)
                    ->schema([
                        TextInput::make('title')
                            ->label('Title'),
                        FileUpload::make('attachment')
                            ->required()
                            ->image(),
                        TextInput::make('caption')
                            ->label('Caption'),
                    ]),
                RichEditor::make('content')
                    ->label('Content')
                    ->required()
                    ->columnSpan(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail')
                    ->label('Thumbnail'),
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('slug')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('excerpt')
                    ->searchable()
                    ->sortable(),
                SelectColumn::make('status')
                    ->label('Status')
                    ->rules(['required'])
                    ->options([
                        "draft" => "Draft",
                        "published" => "Published",
                    ]),
                TextColumn::make('created_at')
                    ->searchable()
                    ->sortable(),
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
            'index' => Pages\ListHiddenGemArticles::route('/'),
            'create' => Pages\CreateHiddenGemArticle::route('/create'),
            'edit' => Pages\EditHiddenGemArticle::route('/{record}/edit'),
        ];
    }
}
