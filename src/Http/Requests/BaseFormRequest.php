<?php

namespace Nitm\Notifications\Http\Requests;

use Nitm\Content\Models\User;
use InfyOm\Generator\Request\APIRequest as FormRequest;
use Nitm\Notifications\Contracts\Models\SupportsNotifications;

class BaseFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(SupportsNotifications $user, $model = null)
    {
        if (!$model) {
            return true;
        }

        if ($this->isMethod('post') || $this->isMethod('put')) {
            return $user->can('create', $model) || $user->can('update');
        }

        if ($this->isMethod('delete')) {
            return $user->can('delete', $model);
        }

        return true;
    }

    public function rules()
    {
        return [];
    }
}