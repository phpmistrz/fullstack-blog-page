<?php

namespace App\Filament\Resources\PostResource\Widgets;

use App\Models\Post;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class PostStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Opuplikowanych postów', Post::where('published_at', '<=', now())->count()),
            Stat::make('Czekają na publikację', Post::where('published_at', '>=', now())->count()),
            Stat::make('Suma gier 5/5', Post::where('rating', '5')->count()),

        ];
    }
}
