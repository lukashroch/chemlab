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
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                Rule::unique('users', 'name')->ignore($this->route('user') ? $this->route('user')->id : null)
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->route('user') ? $this->route('user')->id : null)
            ],
            'roles' => 'array',
            'roles.*' => 'array',
            'roles.*.*' => 'exists:roles,name',
        ];
    }
}
