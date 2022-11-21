<?php

namespace App\Http\Livewire\Post;

use App\Traits\PostTrait;

class Listing extends Base
{
    public $search;

    public function resetFilters(): void
    {
        $this->resetExcept();
    }

    public function render()
    {
        return view('livewire.post.listing')->extends('layouts.app');
    }

    public function getPostsProperty()
    {
        return $this->searchPosts($this->search);
    }
}
