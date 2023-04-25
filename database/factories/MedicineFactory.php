<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Medicine>
 */
class MedicineFactory extends Factory
{
    public function definition(): array
    {
        return [
            'price' => $this->faker->numberBetween(200, 100000),
            'name' => $this->faker->firstName(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
