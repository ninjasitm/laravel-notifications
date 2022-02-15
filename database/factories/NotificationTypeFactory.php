<?php

namespace Database\Factories\Nitm\Notifications\Models;

/**
 * @var \Illuminate\Database\Eloquent\Factory $factory
 */

use Nitm\Notifications\Models\NotificationType;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = NotificationType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'notification_class' => '\App\Listeners\NewComment'
        ];
    }
}