<?php

namespace Database\Factories\Nitm\Notifications\Models;

/**
 * @var \Illuminate\Database\Eloquent\Factory $factory
 */

use Nitm\Notifications\Models\Notification;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Notification::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => \Nitm\Notifications\Models\User::factory()->create()->id,
            'body' => $this->faker->text()
        ];
    }
}