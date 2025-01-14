<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Video>
 */
class VideoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'slug' => $this->faker->slug,
            'vimeo_id' => $this->faker->uuid,
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'duration' => $this->faker->numberBetween(1, 99),
        ];
    }
}
