<?php

namespace App\Http\Livewire\Post;

class View extends Base
{
    public $post;
    public $postStatuses;
    public $postId;
    public $showFullContent = true;
    public $componentTitle = 'View Post';

    public function mount($id)
    {
        $this->postId = $id;
        $this->postStatuses = $this->getPostStatues();
        $this->post = $this->getPostById($this->postId);
    }

    public function render()
    {
        return parent::doRender('post.view');
    }
}
