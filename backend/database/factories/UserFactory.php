<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User> */
class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'email' => fn(): string => $this->faker->email,
            'password' => fn(): string => bcrypt($this->faker->password),
            'name' => fn(): string => $this->faker->name,
            'phone' => fn(): string => sprintf('7937%d', mt_rand(1000000, 9999999)),
        ];
    }
}
