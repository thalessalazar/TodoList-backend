<?php

namespace Database\Factories;

use App\Enums\TransactionEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => fake()->sentence(),
            'value' => fake()->numberBetween(0, 1000000000),
            'date' => fake()->dateTime(),
            'type' => fake()->randomElement(TransactionEnum::TYPE),
        ];
    }
}
