<?php

namespace App\Http\Livewire\Post;

class View extends Base
{
    public $post;
    public $postStatuses;
    public $postId;
    public $showFullContent = true;

    public function mount($id)
    {
        $this->postId = $id;
        $this->postStatuses = $this->getPostStatues();
        $this->post = $this->getPostById($this->postId);
    }

    public function render()
    {
        return view('post.view')->extends('layouts.app');
    }
}
