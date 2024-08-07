<?php

namespace App\Filament\Resources\CategoryResource\Widgets;

use App\Models\Category;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class CategoryStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {

        $mostPopularCategory = Category::withCount('posts')->orderBy('posts_count', 'desc')->first();

        $mostPopularCategoryName = $mostPopularCategory->title;

        return [
            Stat::make('Kategorii Łącznie', Category::count()),
            Stat::make('Najpopularniejsza kategoria', $mostPopularCategoryName),

        ];
    }
}
