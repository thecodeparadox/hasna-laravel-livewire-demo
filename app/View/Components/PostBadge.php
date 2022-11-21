<?php

namespace App\View\Components;

use App\Enums\PostStatus;
use App\Models\Post;
use Illuminate\View\Component;

class PostBadge extends Component
{
    /**
     * A Post info
     *
     * @var Post
     */
    public Post $post;

    /**
     * Badge Type
     *
     * @var mixed
     */
    public $type;

    /**
     * Status Name
     *
     * @var mixed
     */
    public $content;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
        $this->type = PostStatus::getColor($this->post->status);
        $this->content = $this->post->status;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.post-badge');
    }
}
