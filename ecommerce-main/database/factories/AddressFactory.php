<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'address' => $this->faker->address,
            'detail' => $this->faker->text,
            'phone' => $this->faker->phoneNumber,
            'neighborhood' => $this->faker->city,
            'city' => $this->faker->city,
        ];
    }
}
