<?php

namespace Database\Factories;

use App\Models\JobPost;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobPostFactory extends Factory
{
    protected $model = JobPost::class;

    public function definition(): array
    {
        return [
            'summary' => $this->faker->sentence,
            'body' => $this->faker->paragraph(4),
            'user_id' => User::factory()->create(['role' => 'poster'])->id,
        ];
    }
}
