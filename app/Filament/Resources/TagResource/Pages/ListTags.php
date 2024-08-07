<?php

namespace App\Filament\Resources\TagResource\Pages;

use Filament\Actions;
use App\Filament\Resources\TagResource;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\CategoryResource\Widgets\CategoryStatsOverview;
use App\Filament\Resources\TagResource\Widgets\TagStatsOverview;

class ListTags extends ListRecords
{
    protected static string $resource = TagResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array{
        return [
            TagStatsOverview::class,
        ];
    }
}
