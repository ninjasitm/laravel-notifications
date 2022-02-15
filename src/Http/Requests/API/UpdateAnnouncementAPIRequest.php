<?php

namespace Nitm\Notifications\Http\Requests\API;

use Illuminate\Validation\Rule;
use Nitm\Notifications\Models\Announcement;
use Nitm\Notifications\Http\Requests\API\CreateAnnouncementAPIRequest;

class UpdateAnnouncementAPIRequest extends CreateAnnouncementAPIRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = Announcement::$rules;

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