<?php

namespace App\Filament\Pages;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Tables\Table;

class DashboardMaps extends Page implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];
    public ?array $points = [];

    protected static ?string $navigationIcon = 'heroicon-o-document-text';


    protected static string $view = 'filament.pages.dashboard-maps-page';

    public function mount(): void
    {
        $this->form->fill([
            'total_users' => request('total_users') ?? '100',
        ]);

        $this->points = User::latest("last_online")->limit($this->form->getState()['total_users'])->get()->toArray();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()
                    ->schema([
                        Select::make('total_users')
                            ->label('Total Users')
                            ->options([
                                '100' => '100',
                                '500' => '500',
                                '1000' => '1000',
                                '10000' => '10000',
                                '-1' => 'Semua User',
                            ]),
                ])
                ->maxWidth('sm'),
            ])
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('search')
                ->label('Cari Data')
                ->submit('search'),
        ];
    }

    public function search(): void
    {
        $this->redirectRoute('filament.admin.pages.dashboard-maps', ['total_users' => $this->form->getState()['total_users']]);
    }
}
