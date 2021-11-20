<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "total_price" => rand(100, 500),
            "customer_name" => $this->faker->name(),
            "customer_phone" => $this->faker->tollFreePhoneNumber,
            "customer_address" => $this->faker->streetAddress,
            "transportation_costs" => rand(10, 100),
            "payments" => array_rand([0, 1]),
        ];
    }
}