<?php

namespace Nitm\Notifications\Http\Requests\API;

use Nitm\Notifications\Models\User;
use Nitm\Notifications\Models\NotificationType;
use Illuminate\Validation\Rule;

class UpdateNotificationTypeAPIRequest extends CreateNotificationTypeAPIRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = NotificationType::$rules;

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     * In the {{field}}.{{rule}} format
     *
     * @return array
     */
    public function messages()
    {
        return [];
    }
}
