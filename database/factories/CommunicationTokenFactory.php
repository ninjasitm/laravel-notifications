<?php

namespace Database\Factories\Nitm\Notifications\Models;

use Nitm\Notifications\Models\CommunicationToken;
use Nitm\Notifications\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommunicationTokenFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CommunicationToken::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'token' => $this->faker->uuid,
            'device_id' => $this->faker->uuid,
            'user_id' => User::factory()->create()->id,
        ];
    }
}
