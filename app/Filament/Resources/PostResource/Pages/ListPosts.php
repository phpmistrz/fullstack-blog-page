<?php

namespace App\Filament\Resources\PostResource\Pages;


use Filament\Actions;
use App\Filament\Resources\PostResource;
use App\Filament\Resources\PostResource\Widgets\PostStatsOverview;
use Filament\Resources\Pages\ListRecords;

class ListPosts extends ListRecords
{

  
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
protected function getHeaderWidgets(): array{
        return [
            PostStatsOverview::class,
        ];
    }
   
}
