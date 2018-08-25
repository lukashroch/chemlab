<?php

namespace ChemLab\Http\Requests;

use Illuminate\Validation\Rule;

class UserRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                Rule::unique('users', 'name')->ignore($this->route('user') ? $this->route('user')->id : null)
            ],
            'email' => 'sometimes|required|email|max:255|unique:users,email',
            'teams' => 'array|exists:teams,id',
            'teams.*' => 'integer',
            'roles' => 'array',
            'roles.*' => 'array|exists:roles,id',
            'roles.*.*' => 'integer',
        ];

        return $rules;
    }
}
