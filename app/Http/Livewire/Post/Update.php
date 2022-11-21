<?php

namespace App\Http\Livewire\Post;

use App\Enums\PostStatus;

class Update extends Base
{
    public $post;
    public $postStatuses;
    public $postId;

    // Properties
    public $title = '';
    public $content = '';
    public $status = PostStatus::DRAFT;
    public $slug = '';
    public $componentTitle = 'Update Post';

    public function mount($id = '')
    {
        $this->postId = $id;
        $this->postStatuses = $this->getPostStatues();
        $this->post = $this->getPostById($this->postId);
        $this->refreshProperties();
    }

    public function render()
    {
        return view('post.upsert')->extends('layouts.app');
    }

    /**
     * Validate each form field
     *
     * !NOTE: COMMENT OUT DUE TO ITS EACH EVENT TRIP TO SERVER
     *
     * @param mixed $propertyName
     * @return void
     * @throws Throwable
     * @throws ValidationException
     */
    // public function updated($propertyName): void
    // {
    //     $this->validateOnly($propertyName);
    // }

    /**
     * Update Slug on title input change
     *
     * @return void
     */
    public function updateSlug(): void
    {
        $this->slug = $this->slugify($this->title);
    }

    /**
     * Save Post on form submit
     *
     * @return RedirectResponse
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     * @throws Throwable
     */
    public function savePost()
    {
        $this->validate();

        $postId = $this->post->id ?? null;
        $action = $postId ? 'Update' : 'Create';
        $data = [
            'user_id' => $this->post->user_id ?? $this->authId(),
            'title' => $this->title,
            'content' => $this->content,
            'slug' => $this->slug,
            'status' => $this->status,
            'published_at' => PostStatus::is($this->status, PostStatus::PUBLISHED) ? $this->now() : null
        ];

        $this->upsertPost($data, $postId);

        return redirect()
            ->route('posts')
            ->with('success', __('Post ' . $action . ' successfully'));
    }

    /**
     * For View/Edit Pull target post by ID param or redirect on error
     *
     * @return void|RedirectResponse
     * @throws BindingResolutionException
     * @throws RouteNotFoundException
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    private function fetchPostOrFail()
    {
        if (!$this->postId) {
            return;
        }

        $this->post = $this->getPostById($this->postId);
        if (!$this->post) {
            return redirect()->route('posts')->with('error', __('Post Not Found'));
        }
    }

    /**
     * Reset all reactive props
     *
     * @return void
     * @throws BindingResolutionException
     * @throws RouteNotFoundException
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    private function refreshProperties()
    {
        $this->fetchPostOrFail();

        $this->title = $this->post->title ?? '';
        $this->content = $this->post->content ?? '';
        $this->status = $this->post->status ?? PostStatus::getValue(PostStatus::DRAFT);
        $this->slug = $this->post->slug ?? 'N/A';
    }
}
