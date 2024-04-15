<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BiroArticleResource\Pages;
use App\Filament\Resources\BiroArticleResource\RelationManagers;
use App\Models\BiroArticle;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
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

class BiroArticleResource extends Resource
{
    protected static ?string $model = BiroArticle::class;

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
                Select::make('biro_id')
                    ->label('Biro')
                    ->options(fn() => \App\Models\Biro::all()->pluck('name', 'id'))
                    ->required(),
                Textarea::make('excerpt')
                    ->label('Excerpt'),
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
                SelectColumn::make("status")
                    ->options([
                        "draft" => "Draft",
                        "published" => "Published",
                    ])
                    ->rules(['required']),
                TextColumn::make("biro.name")
                    ->searchable()
                    ->sortable(),
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
            'index' => Pages\ListBiroArticles::route('/'),
            'create' => Pages\CreateBiroArticle::route('/create'),
            'edit' => Pages\EditBiroArticle::route('/{record}/edit'),
        ];
    }
}
