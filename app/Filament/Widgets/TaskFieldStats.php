<?php

namespace App\Filament\Widgets;

use App\Models\Agent;
use App\Models\AgentReport;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class TaskFieldStats extends BaseWidget
{
    protected function getColumns(): int
    {
        return 2;
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Jumlah Tugas Lapangan', Agent::count())
                ->description('Total semua tugas lapangan')
                ->icon('heroicon-o-clipboard-document-list')
                ->color('success'),

            Stat::make('Laporan Tugas Lapangan', AgentReport::count())
                ->description('Laporan tugas lapangan')
                ->icon('heroicon-o-clipboard-document-list')
                ->color('info'),
        ];
    }
}

