<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\ShareContent;
use Filament\Resources\Resource;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ShareContentResource\Pages;
use App\Filament\Resources\ShareContentResource\RelationManagers;

class ShareContentResource extends Resource
{
    protected static ?string $model = ShareContent::class;
    protected static ?string $label = 'Share Content';
    protected static ?string $pluralLabel = 'Share Content';
    protected static ?string $navigationIcon = 'heroicon-o-photo';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', auth()->id());
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label('Judul')
                    ->required(),
                FileUpload::make('image')
                    ->label('Gambar')
                    ->required(),
                TextInput::make('link')
                    ->label('Link')->activeUrl(),
                Textarea::make('caption')
                    ->required()
                    ->autosize(),
                Textarea::make('description')
                    ->nullable()
                    ->autosize(),
                Radio::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'publish' => 'Publish'
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable()->sortable()
                    ->label('Judul'),
                ImageColumn::make('image')
                ->disk('r2')
                ->size(100),
                // TextColumn::make('status')
                //     ->badge()
                //     ->color(fn (string $state): string => match ($state) {
                //         'draft' => 'gray',
                //         'published' => 'success',
                //         'null' => 'warning',
                // })
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListShareContents::route('/'),
            'create' => Pages\CreateShareContent::route('/create'),
            'edit' => Pages\EditShareContent::route('/{record}/edit'),
        ];
    }
}
