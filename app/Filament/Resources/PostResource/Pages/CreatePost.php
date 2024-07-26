<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Models\Post;
use Filament\Actions;
use App\Filament\Resources\PostResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePost extends CreateRecord
{

    use CreateRecord\Concerns\HasWizard;
    protected static string $resource = PostResource::class;

    protected function getSteps(): array
    {
        return Post::getSteps();
    }
    


}


