<?php

namespace App\Http\Livewire\Post;

use App\Enums\PostStatus;
use App\Repositories\PostRepository;
use Livewire\Component;

class Update extends Component
{
    protected PostRepository $postRepo;

    public $post;
    public $postStatuses;

    // Properties
    public $title = '';
    public $content = '';
    public $status = PostStatus::DRAFT;
    public $slug = '';

    public function __construct()
    {
        $this->postRepo = new PostRepository();
    }

    public function mount($id)
    {
        $this->postStatuses = PostStatus::getEnumValues();
        $this->post = $this->postRepo->getById($id);
    }

    public function render()
    {
        return view('livewire.post.update')->extends('layouts.app');
    }
}
