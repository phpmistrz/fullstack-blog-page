<?php

namespace App\Filament\Resources\TagResource\Widgets;

use App\Models\Tag;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class TagStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {

        $mostPopularTag = Tag::withCount('posts')->orderBy('posts_count', 'desc')->first();

        $mostPopularTagName = $mostPopularTag->title;

        return [
            Stat::make('Tagów Łącznie', Tag::count()),
            Stat::make('Najpopularniejszy tag', $mostPopularTagName),  

        ];
    }
}
