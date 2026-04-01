<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'bio' => $this->faker->paragraph(),
            'phone' => $this->faker->phoneNumber(),
            'avatar_url' => $this->faker->imageUrl(),
        ];
    }
}