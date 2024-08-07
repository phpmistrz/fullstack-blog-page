<?php

namespace App\Filament\Resources\TopGameResource\Widgets;

use App\Models\TopGame;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TopGameStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Liczba gier w Topce', TopGame::count()),

        ];
    }
}
