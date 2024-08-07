<?php

namespace App\Livewire\Blog;

use Livewire\Component;

class BlogIndex extends Component
{

    public $title = 'Strona ze wszytkimi postami';
    public $description = 'Strona ze wszytkimi postami meta';

    public function render()
    {
        return view('livewire.blog.blog-index')->layout('components.layouts.app',[
            'title' => $this->title,
            'description' => $this->description,
        ]);
    }
}
