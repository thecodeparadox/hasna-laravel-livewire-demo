<?php

namespace Database\Factories;

use App\Enums\PostStatus;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $title = fake()->sentence();
        $slug = Str::slug($title);
        return [
            'user_id' => User::count() ? User::inRandomOrder()->first()->id : User::factory(),
            'title' => $title,
            'slug' => $slug,
            'content' => fake()->text(1000),
            'status' => fake()->randomElement(PostStatus::getEnumValues())
        ];
    }
}
