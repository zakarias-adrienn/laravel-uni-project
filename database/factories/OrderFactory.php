<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'address' => $this->faker->address(),
            'comment' => $this->faker->realText($maxNbChars = 200, $indexSize = 1),
            'payment_method' => $this->faker->randomElement($array = array ('CASH', 'CARD')),
            'status' => $this->faker->randomElement($array = array ('RECEIVED', 'REJECTED', 'ACCEPTED')),
        ];
    }
}
