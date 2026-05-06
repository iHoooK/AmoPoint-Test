<?php

namespace Database\Factories;

use App\Models\Joke;
use Illuminate\Database\Eloquent\Factories\Factory;

class JokeFactory extends Factory
{
    protected $model = Joke::class;

    public function definition(): array
    {
        return [
            'external_id' => fake()->numberBetween(1, 100000),
            'type' => fake()->randomElement(['general', 'programming', 'knock-knock']),
            'setup' => fake()->sentence(),
            'punchline' => fake()->sentence(),
        ];
    }
}
