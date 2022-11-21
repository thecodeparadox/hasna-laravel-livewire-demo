<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

interface PostRepositoryInterface
{
    public function upsert(array $data, int | null $postId = null): Post;
    public function getBySlug(string $slug): Post | null;
    public function getByUserId(int $userId, string $search = '', int $pageSize = 10): Collection;
    public function getById(string | int $id): Post | null;
    public function deleteById(int $id): int;
}

class PostRepository implements PostRepositoryInterface
{
    /**
     * Create/Update a post
     *
     * @param array $data
     * @return Post
     */
    public function upsert(array $data, int | null $postId = null): Post
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
    public function getByUserId(int $userId, string $search = '', int $pageSize = 10): Collection
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
    public function getBySlug(string $slug): Post | null
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
    public function getById(string | int $postId): Post | null
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
    public function deleteById(int $postId): int
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
