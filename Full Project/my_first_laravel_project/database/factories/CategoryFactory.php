<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // আমরা কী কী Fake Data চাই তা এখানে লিখতে হবে।
            'title'=>$this->faker->word,
            'description'=>$this->faker->paragraph,
            'image'=>$this->faker->image('storage/app/public', 200, 300, 'cats', false),
        ];
    }
}
