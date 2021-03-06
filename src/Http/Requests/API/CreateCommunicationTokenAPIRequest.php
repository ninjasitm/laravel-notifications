<?php

namespace Nitm\Notifications\Http\Requests\API;

use Illuminate\Validation\Rule;
use Nitm\Content\Models\User;
use Nitm\Notifications\Contracts\Models\SupportsNotifications;
use Nitm\Notifications\Http\Requests\BaseFormRequest;
use Nitm\Notifications\Models\CommunicationToken;

class CreateCommunicationTokenAPIRequest extends BaseFormRequest
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
        return CommunicationToken::$rules;
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