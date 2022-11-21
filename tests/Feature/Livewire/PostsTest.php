<?php

namespace Tests\Feature\Livewire;

use App\Enums\PostStatus;
use App\Http\Livewire\Posts;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class PostsTest extends TestCase
{
    /** @test  */
    public function the_component_can_render()
    {
        $this->actingAs(User::where('email', 'email@email.com')->first());

        $component = Livewire::test(Posts::class);
        $component->assertStatus(200);
    }

    /** @test  */
    public function should_create_post()
    {
        $this->actingAs(User::where('email', 'email@email.com')->first());

        Livewire::test(Posts::class)
            ->set('title', 'My Test Title')
            ->set('slug', 'my-test-slug')
            ->set('content', 'some test content...')
            ->set('status', PostStatus::getValue('DRAFT'))
            ->call('savePost');

        $this->assertTrue(Post::whereTitle('My Test Title')->exists());
    }

    /** @test  */
    public function should_be_validation_errors()
    {
        $this->actingAs(User::where('email', 'email@email.com')->first());

        Livewire::test(Posts::class)
            ->set('title', '')
            ->set('status', 'UNKNOWN')
            ->call('savePost')
            ->assertHasErrors([
                'title' => 'required',
                'status' => 'in',
            ]);
    }

    /** @test  */
    public function should_create_post_and_redirect_to_listing_page()
    {
        $this->actingAs(User::where('email', 'email@email.com')->first());

        Livewire::test(Posts::class)
            ->set('title', 'My Test Title')
            ->set('slug', 'my-test-slug')
            ->set('content', 'some test content...')
            ->set('status', PostStatus::getValue('DRAFT'))
            ->call('savePost')
            ->assertRedirect('/posts')
            ->assertStatus(200);
    }

    /** @test  */
    public function should_render_view_page_with_given_param_post_id()
    {
        $this->actingAs(User::where('email', 'email@email.com')->first());

        $request = $this->get(route('post.view', ['id' => 1]));
        // $request->assertSet('postId', 1);
        $request->assertStatus(200);
        $request->assertSeeText('View Post');
    }

    /** @test  */
    public function should_render_edit_page_with_given_param_post_id()
    {
        $this->actingAs(User::where('email', 'email@email.com')->first());

        $request = $this->get(route('post.edit', ['id' => 1]));
        $request->assertStatus(200);
        $request->assertSeeText('Update Post');
    }

    /** @test  */
    public function should_emit_ask_permission_event_on_delete_button_hit()
    {
        $this->actingAs(User::where('email', 'email@email.com')->first());

        Livewire::test(Posts::class)
            ->call('performDelete', 1)
            ->assertEmitted('askPermission', 1);
    }
}
