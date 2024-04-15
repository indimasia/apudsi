<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BiroResource\Pages;
use App\Filament\Resources\BiroResource\RelationManagers;
use App\Models\Biro;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class BiroResource extends Resource
{
    protected static ?string $model = Biro::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nama')
                    ->required(),
                TextInput::make('code')
                    ->label('Kode')
                    ->unique('biros', 'code', ignoreRecord: true)
                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('code', Str::upper(str_replace(" ", "", $state))))
                    ->live(onBlur:true, debounce:500),
                TextInput::make('owner')
                    ->label('Pemilik')
                    ->required(),
                TextInput::make('marketing_phone')
                    ->label('No WA Marketing')
                    ->required()
                    ->rules('doesnt_start_with:08'),
                Select::make('province_code')
                    ->label('Provinsi')
                    ->required()
                    ->options(fn () => \App\Models\Province::pluck('nama', 'kode'))
                    ->live(),
                Select::make('city_code')
                    ->label('Kabupaten/Kota')
                    ->required()
                    ->options(fn (Get $get) => \App\Models\City::where('kode_provinsi', $get('province_code'))->pluck('nama', 'kode')),
                Textarea::make("address")
                    ->label("Alamat")
                    ->required(),
                TextInput::make('average_person_per_year')
                    ->type('number')
                    ->label('Rata-rata Jemaah per Tahun')
                    ->required(),
                Toggle::make('is_active')
                    ->label('Aktif'),
                Toggle::make('admin.is_demo')
                    ->label('Demo'),
                FileUpload::make('logo')
                    ->label('Logo')
                    ->image()
                    ->directory("biros")
                    ->required(fn (string $context): bool => $context === 'create')
                    ->visibility('public'),
                    
                Fieldset::make('admin')
                    ->relationship('admin')
                    ->schema([
                        TextInput::make('phone')
                            ->label('No WA Admin')
                            ->required()
                            ->rules('doesnt_start_with:08'),
                        TextInput::make("password")
                            ->label("Password Admin")
                            ->type("password")
                            ->required(fn (string $context): bool => $context === 'create')
                            ->rules("min:8"),
                    ])
                    ->mutateRelationshipDataBeforeCreateUsing(function (array $data, Get $get) {
                        $data['name'] = $get("name");
                        $data['password'] = bcrypt($data['password']);
                        $data['is_active'] = $get("is_active");
                        $data['province_code'] = $get("province_code");
                        $data['city_code'] = $get("city_code");
                        return $data;
                    })->mutateRelationshipDataBeforeSaveUsing(function (array $data, Get $get) {
                        $data['name'] = $get("name");
                        $data['is_active'] = $get("is_active");
                        $data['province_code'] = $get("province_code");
                        $data['city_code'] = $get("city_code");
                        if($data['password'] !== null) {
                            $data['password'] = bcrypt($data['password']);
                        } else {
                            unset($data['password']);
                        }
                        

                        return $data;
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("name")
                    ->label("Nama")
                    ->sortable()
                    ->searchable(),
                TextColumn::make("code")
                    ->label("Kode")->sortable()
                    ->searchable(),
                TextColumn::make("owner")
                    ->label("Pemilik")
                    ->sortable()
                    ->searchable(),
                TextColumn::make("admin.phone")
                    ->label("No WA Admin")
                    ->sortable()
                    ->searchable(),
                TextColumn::make("marketing_phone")
                    ->label("No WA Marketing")
                    ->sortable()
                    ->searchable(),
                TextColumn::make("province.nama")
                    ->label("Provinsi"),
                TextColumn::make("city.nama")
                    ->label("Kabupaten/Kota"),
                TextColumn::make("address")
                    ->label("Alamat"),
                TextColumn::make("average_person_per_year")
                    ->label("Rata-rata Jemaah per Tahun")
                    ->sortable()
                    ->searchable(),
                ToggleColumn::make("is_active")
                    ->label("Aktif")
                    ->afterStateUpdated(function(Biro $biro) {
                        $biro->admin->is_active = $biro->is_active;
                        $biro->admin->save();
                    })
                    ->sortable(),
                ToggleColumn::make("admin.is_demo")
                    ->label("Demo")
                    ->sortable(),
                ImageColumn::make("logo")
                    ->label("Logo")
                    ->size(100),
                TextColumn::make("created_at")
                    ->label("Waktu Pembuatan")
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageBiros::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
