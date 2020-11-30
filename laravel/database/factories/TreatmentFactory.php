<?php

namespace Database\Factories;

use App\Models\Treatment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TreatmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Treatment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence(2),
            'description' => $this->faker->text(50),
            'price' => $this->faker->randomFloat(1, 5, 60)
        ];
    }
}
