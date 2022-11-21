<?php

namespace App\Http\Livewire;

use App\Enums\PostStatus;
use App\Models\Post;
use App\Repositories\PostRepository;
use App\Traits\PostTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithPagination;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Container\ContainerExceptionInterface;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Throwable;

class Posts extends Component
{
    use WithPagination, PostTrait;

    protected PostRepository $postRepo;
    protected $listeners = ['purgePost'];

    // Post fields
    public $title = '';
    public $content = '';
    public $status = PostStatus::DRAFT;
    public $slug = '';

    // tracking props
    public $search;
    public $post;
    public $postId = '';
    public $opMode = 'listing';
    public $componentTitle = 'Posts Listing';
    public $postStatuses;

    public function __construct()
    {
        parent::__construct();

        $this->postStatuses = PostStatus::getEnumValues();
        $this->postRepo = new PostRepository();
    }

    protected function rules(): array
    {
        return $this->getPostValidationRules();
    }

    public function getPostsProperty()
    {
        return $this->postRepo->searchPosts($this->search);
    }

    /**
     * Component mount lifecycle hook.
     * Making some rendering decision here
     *
     * @param string $id
     * @return void
     * @throws BindingResolutionException
     * @throws RouteNotFoundException
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function mount($id = ''): void
    {
        $this->postId = $id;
        $this->opMode = 'listing';
        $routeName = request()->route()->getName();

        switch ($routeName) {
            case 'post.create':
                $this->componentTitle = 'Create Post';
                $this->opMode = 'create';
                break;

            case 'post.edit':
                $this->componentTitle = 'Update Post';
                $this->opMode = 'update';
                break;

            case 'post.view':
                $this->componentTitle = 'View Post';
                $this->opMode = 'view';
                break;
        }

        $this->refreshProperties();
    }

    /**
     * Render the component
     *
     * @return mixed
     * @throws BindingResolutionException
     */
    public function render(): mixed
    {
        return view('livewire.posts')->extends('layouts.app');
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
     * On pagination change reset reactive props (some exception)
     *
     * @return void
     */
    public function resetFilters(): void
    {
        $this->resetExcept(['opMode']);
    }

    /**
     * Update Slug on title input change
     *
     * @return void
     */
    public function updateSlug(): void
    {
        $this->slug = Str::slug($this->title);
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
        $action = ucwords($this->opMode);
        $this->validate();

        $data = [
            'user_id' => $this->post->user_id ?? Auth::user()->id,
            'title' => $this->title,
            'content' => $this->content,
            'slug' => $this->slug,
            'status' => $this->status,
            'published_at' => PostStatus::is($this->status, PostStatus::PUBLISHED) ? Carbon::now() : null
        ];

        $post = $this->postRepo->upsert($data, $this->post->id ?? null);

        return redirect()
            ->route('posts')
            ->with('success', __('Post ' . $action . ' successfully'));
    }

    /**
     * Perform Delete Post
     *
     * @param mixed $postId
     * @return RedirectResponse
     * @throws BindingResolutionException
     * @throws RouteNotFoundException
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function performDelete($postId)
    {
        $this->postId = $postId;
        $this->emit('askPermission', $this->postId);
    }

    public function purgePost($postId)
    {
        $this->postRepo->deleteById($this->postId);
        return redirect()->route('posts')->with('success', __('Post deleted successfully'));
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

        $this->post = $this->postRepo->getById($this->postId);
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
