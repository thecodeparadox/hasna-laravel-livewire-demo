<?php

namespace App\Http\Livewire\Post;

class Listing extends Base
{
    public $search;
    public $backNav = false;
    public $componentTitle = 'Posts Listing';

    public function resetFilters(): void
    {
        $this->resetExcept();
    }

    public function render()
    {
        return parent::doRender('post.listing');
    }

    public function getPostsProperty()
    {
        return $this->searchPosts($this->search);
    }
}
