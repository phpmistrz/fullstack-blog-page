<?php

namespace App\Filament\Resources\CompletedGameResource\Widgets;

use App\Models\CompletedGame;
use Illuminate\Support\Carbon;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class CompletedGameStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {

        $currentYear = Carbon::now()->year;

        return [
            Stat::make('Ukończonych gier', CompletedGame::count()),
            Stat::make('Ukończonych gier w ' . $currentYear, CompletedGame::where('year', $currentYear)->count()),
        ];
    }
}
