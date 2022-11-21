<?php

namespace App\Http\Controllers;

use App\Repositories\PostRepository;

class PostController extends Controller
{
    protected PostRepository $postRepo;

    public function __construct(PostRepository $postRepo)
    {
        $this->postRepo = $postRepo;
    }

    public function index()
    {
        $search = request()->get('search');
        $posts = $this->postRepo->searchPosts($search);
        return view('post.index', ['posts' => $posts, 'search' => $search]);
    }
}
