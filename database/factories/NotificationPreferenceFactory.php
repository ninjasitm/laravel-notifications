<?php

namespace Database\Factories\Nitm\Notifications\Models;

use Nitm\Content\Models\User;
use Nitm\Notifications\Models\NotificationType;
use Nitm\Notifications\Models\NotificationPreference;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationPreferenceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = NotificationPreference::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $class = $this->faker->randomElement([User::class]);
        return [
            'user_id' => $class::factory()->create()->id,
            'is_enabled' => $this->faker->boolean,
            'via_web' => $this->faker->boolean,
            'via_mobile' => $this->faker->boolean,
            'via_email' => $this->faker->boolean,
            'via_sms' => $this->faker->boolean,
            'type_id' => NotificationType::factory()->create()->id
        ];
    }
}