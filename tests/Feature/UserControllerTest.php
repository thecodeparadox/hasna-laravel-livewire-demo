<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function test_the_application_returns_a_successful_response()
    {
        $response = $this->get(route('user.login'));
        $response->assertOk();
    }

    public function test_login_should_failed_due_to_invalid_credentials()
    {
        $response = $this->json('POST', route('user.login'), ['email' => 'test@test.com', 'password' => 'fake']);

        $response->assertStatus(302);
        $response->assertSessionHas('error', __('auth.invalid_credentials'));
    }

    public function test_login_should_be_successful()
    {
        $response = $this->json('POST', route('user.login'), ['email' => 'email@gmail.com', 'password' => 'password']);

        $response->assertStatus(302);
        $response->assertRedirectToRoute('posts.listing');
    }

    public function test_login_should_be_failed_due_to_inactive_user()
    {
        list($_, $inactiveUser) = User::factory()->findOrCreateTestUsers();

        $loginData = ['email' => $inactiveUser->email, 'password' => 'password'];
        $response = $this->json('POST', route('user.login'), $loginData);

        $response->assertStatus(302);
        $response->assertSessionHas('error', __('auth.login_failed_inactive'));
    }

    public function test_user_signup_should_failed_due_to_unique_email_constrain()
    {
        $user = [
            'first_name' => 'First',
            'last_name' => 'Last',
            'email' => 'email@email.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ];

        $response = $this->json('POST', route('user.store'), $user);

        $response->assertJsonValidationErrors(['email']);
        $response->assertStatus(422);
    }

    public function test_user_signup_should_failed_due_to_validation_fail()
    {
        $user = [
            'first_name' => 'First',
            'last_name' => 'Last',
            'email' => 'email@email.com',
            'password' => '1',
            'password_confirmation' => 'password'
        ];

        $response = $this->json('POST', route('user.store'), $user);

        $response->assertJsonValidationErrors(['password', 'password_confirmation']);
        $response->assertStatus(422);
    }

    public function test_user_should_signup_successfully()
    {
        $user = [
            'first_name' => 'First',
            'last_name' => 'Last',
            'email' => fake()->unique()->safeEmail(),
            'password' => 'password',
            'password_confirmation' => 'password'
        ];
        $response = $this->json('POST', route('user.store'), $user);

        $this->assertDatabaseHas('users', [
            'email' => $user['email'],
        ]);
        $response->assertStatus(302);
        $response->assertRedirectToRoute('user.login');
        $response->assertSessionHas('info', __('auth.signup_success'));
    }

    public function test_logout_should_success_and_redirect_to_login()
    {
        $response = $this->get(route('user.logout'));

        $response->assertStatus(302);
        $response->assertRedirectToRoute('home');
    }
}
