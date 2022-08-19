<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
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
        $postStatusArr = ['draft', 'publish', 'private'];
        return [
            'title' => fake()->name(),
            'content' => fake()->text(),
            'user_id' => rand(1, 100),
            'category_id' => rand(1, 3),
            'status' => $postStatusArr[rand(0, 2)],
        ];
    }
}
