<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Spatie\Permission\Models\Role;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nama')
                    ->required(),
                Select::make('role_id')
                    ->relationship('roles', 'name',
                        modifyQueryUsing: function (Builder $query) {
                            return $query->where('name', '!=', 'biro');
                        })
                    ->preload()
                    ->required(),
                // Select::make('roles')
                //     ->label('Role')
                //     ->options(function(string $context) {
                //         $role = new Role();
                //         if($context === 'create') {
                //             $role->where('name', '!=', 'biro');
                //         }

                //         return $role->pluck('name', 'id');
                //     })
                //     ->multiple(),
                TextInput::make('email')
                    ->label('Email'),
                TextInput::make('password')
                    ->label('Password')
                    ->required(fn (string $context): bool => $context === 'create')
                    ->password()
                    ->revealable(),
                TextInput::make('phone')
                    ->label('No. WA')
                    ->required()
                    ->rules('doesnt_start_with:08'),
                Select::make('gender')
                    ->label('Jenis Kelamin')
                    ->options([
                        'M' => 'Laki-laki',
                        'F' => 'Perempuan',
                    ])
                    ->required(),
                TextInput::make("spph")
                    ->label('SPPH'),
                // Select::make('biro_id')
                //     ->label('Biro')
                //     ->options(fn () => \App\Models\Biro::pluck('name', 'id')),
                Select::make('province_code')
                    ->label('Provinsi')
                    ->options(fn () => \App\Models\Province::pluck('nama', 'kode'))
                    ->live(),
                Select::make('city_code')
                    ->label('Kota')
                    ->options(fn (Get $get) => \App\Models\City::where('kode_provinsi', $get('province_code'))->pluck('nama', 'kode')),
                Toggle::make('is_active')
                    ->label('Aktif'),
                Toggle::make('is_demo')
                    ->label('Aktif'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                TextColumn::make("roles.name")
                    ->label('Role')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('phone')
                    ->label('No. WA')
                    ->searchable()
                    ->sortable(),
                TextColumn::make("gender")
                    ->label('Jenis Kelamin')
                    ->formatStateUsing(fn(string $state) => $state == 'M' ? 'Laki-laki' : 'Perempuan')
                    ->searchable()
                    ->sortable(),
                // TextColumn::make("biro.name")
                //     ->label('Biro')
                //     ->searchable()
                //     ->sortable(),
                TextColumn::make("spph")
                    ->label('SPPH')
                    ->searchable()
                    ->sortable(),
                TextColumn::make("province.nama")
                    ->label('Provinsi')
                    ->searchable()
                    ->sortable(),
                TextColumn::make("city.nama")
                    ->label('Kota')
                    ->searchable()
                    ->sortable(),
                ToggleColumn::make('is_active')
                    ->label('Aktif')
                    ->sortable(),
                ToggleColumn::make('is_demo')
                    ->label('Demo')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        if($data['password'] === null) {
                            unset($data['password']);
                        } else {
                            $data['password'] = bcrypt($data['password']);
                        }
                
                        return $data;
                    }),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(fn (Builder $query) => $query->whereDoesntHave("roles", fn(Builder $q2) => $q2->where("name", "biro")));
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageUsers::route('/'),
        ];
    }
}
