<?php

namespace App\Http\Livewire\Post;

use App\Traits\PostTrait;
use App\Traits\UtilTrait;
use Livewire\Component;

class Base extends Component
{
    use PostTrait, UtilTrait;

    /**
     * Event listeners
     *
     * @var string[]
     */
    public $listeners = ['purgePost'];

    /**
     * Rules property for Livewire validation
     *
     * @return array
     */
    protected function rules(): array
    {
        return $this->getPostValidationRules();
    }

    /**
     * Prepare Post Deletion
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
        if (!$postId) {
            return false;
        }
        $this->emit('askPermission', $postId);
    }

    /**
     * Perform post delete and redirect to listing
     *
     * @param mixed $postId
     * @return RedirectResponse
     * @throws BindingResolutionException
     * @throws RouteNotFoundException
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function purgePost($postId)
    {
        $status = $this->deletePostById($postId);
        if ($status) {
            return redirect()->route('posts')->with('success', __('Post deleted successfully'));
        }
        return back()->with('error', __('Deletion Failed'));
    }
}
