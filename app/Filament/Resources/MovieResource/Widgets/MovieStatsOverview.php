<?php

namespace App\Filament\Resources\MovieResource\Widgets;

use App\Models\Movie;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MovieStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Filmów Łącznie', Movie::count()),

        ];
    }
}
