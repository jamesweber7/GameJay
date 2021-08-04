<?php

namespace Database\Factories;

use App\Models\Game;
use Illuminate\Database\Eloquent\Factories\Factory;

class GameFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Game::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'user_id' => 1,
            'simple_description' => $this->faker->sentence(10),
            'detailed_description' => $this->faker->sentence(40),
            'source',
            'width' => 800,
            'height' => 600,
            'fullscreen' => true,
        ];
    }
}
