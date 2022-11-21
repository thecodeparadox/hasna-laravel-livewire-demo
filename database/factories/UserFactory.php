<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Set First user email as pre-known email for testing purpose
     *
     * @return void
     */
    public function configure()
    {
        return $this->afterCreating(function (User $user) {
            if ($user->id === 1) {
                $user->first_name = 'FirstName';
                $user->last_name = 'LastName';
                $user->email = 'email@email.com';
                $user->is_active = 1;
                $user->save();
            }
        });
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'is_active' => (int) fake()->boolean()
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Fetch Or Create Test Users (one active and another inactive)
     *
     * @return Collection
     */
    public function findOrCreateTestUsers(): Collection
    {
        $emails = ['active@email.com', 'inactive@email.com'];

        $users = [[
            'first_name' => 'Active',
            'last_name' => 'User',
            'email' => $emails[0],
            'password' => Hash::make('password'),
            'is_active' => 1
        ], [
            'first_name' => 'Inactive',
            'last_name' => 'User',
            'email' => $emails[1],
            'password' => Hash::make('password'),
            'is_active' => 0
        ]];

        // create active user
        User::upsert($users, ['email'], ['is_active', 'password']);
        return User::whereIn('email', $emails)->get();
    }
}
