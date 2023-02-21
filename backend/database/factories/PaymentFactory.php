<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment> */
class PaymentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => fn(): int => User::factory()->createOne()->getAttribute('id'),
            'sum' => fn(): float => abs($this->faker->randomFloat(2)),
        ];
    }
}
