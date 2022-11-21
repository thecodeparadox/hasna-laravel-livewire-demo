<?php

namespace App\Traits;

use App\Enums\PostStatus;
use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\In;
use Illuminate\Validation\Rules\Unique;

trait PostTrait
{
    // /**
    //  * Event listeners
    //  *
    //  * @var string[]
    //  */
    // public $listeners = ['purgePost'];

    // /**
    //  * Rules property for Livewire validation
    //  *
    //  * @return array
    //  */
    // protected function rules(): array
    // {
    //     return $this->getPostValidationRules();
    // }

    /**
     * Get Post Statuses enums
     *
     * @return array
     */
    public function getPostStatues()
    {
        return PostStatus::getEnumValues();
    }

    /**
     * Get Post Create/edit validation rules
     *
     * @param Request $request
     * @return ((string|Unique)[]|string|(string|In)[]|string[])[]
     */
    public function getPostValidationRules()
    {
        $rules = [
            'title' => [
                'required',
                'min:5',
                'max:255'
            ],
            'slug' => 'required|min:5|max:255',
            'content' =>  'required',
            'status' => ['required', Rule::in(PostStatus::getEnumValues())],
        ];

        return $rules;
    }

    /**
     * Create/Update a post
     *
     * @param array $data
     * @return Post
     */
    public function upsertPost(array $data, int | null $postId = null): Post
    {
        return Post::updateOrCreate(['id' => $postId], $data);
    }

    /**
     * Get Posts for an User with search ability
     *
     * @param int $userId
     * @param string $search
     * @return Collection
     */
    public function getPostByUserId(int $userId, string $search = '', int $pageSize = 10): Collection
    {
        $builder =  Post::where('user_id', $userId);
        if ($search) {
            $builder = $builder->where('title', 'LIKE', "%{$search}%");
        }
        return $builder->latest()
            ->limit(10)
            ->get();
    }

    /**
     * Get a Post by Slug
     *
     * @param string $slug
     * @return Post | null
     */
    public function getPostBySlug(string $slug): Post | null
    {
        return Post::where('slug', $slug)
            ->where('user_id', Auth::user()->id)
            ->firstOrFail();
    }

    /**
     * Get Post by Id
     *
     * @param int $postId
     * @return Post|null
     */
    public function getPostById(string | int $postId): Post | null
    {
        return Post::where('id', $postId)
            ->where('user_id', Auth::user()->id)
            ->first();
    }

    /**
     * Delete Post By Id
     *
     * @param int $postId
     * @return void
     */
    public function deletePostById(int $postId): int
    {
        return Post::where('id', $postId)
            ->where('user_id', Auth::user()->id)
            ->delete();
    }

    /**
     * Search Posts
     *
     * @param string $search
     * @param int $pageSize
     * @return mixed
     */
    public function searchPosts($search = '', $pageSize = 3)
    {
        $builder = Post::where('user_id', Auth::user()->id);
        if ($search) {
            return $builder->where('title', 'LIKE', '%' . $search . '%')
                ->orderBy('updated_at', 'desc')
                ->paginate();
        }
        return $builder->orderBy('updated_at', 'desc')->paginate($pageSize);
    }
}
