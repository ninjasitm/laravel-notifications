<?php

namespace Nitm\Notifications\Http\Requests\API;

use Illuminate\Validation\Rule;
use Nitm\content\Models\User;
use Nitm\Notifications\Contracts\Models\SupportsNotifications;
use Nitm\Notifications\Http\Requests\BaseFormRequest;
use Nitm\Notifications\Models\Announcement;

class CreateAnnouncementAPIRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(SupportsNotifications $user, $model = null)
    {
        return parent::authorize($user, $model);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return Announcement::$rules;
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