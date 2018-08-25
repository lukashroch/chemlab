<?php

namespace ChemLab\Http\Requests;

use ChemLab\Rules\ValidCurrentPassword;

class PasswordRequest extends Request
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
            'password_current' => [
                'required',
                new ValidCurrentPassword()
            ],
            'password' => [
                'required',
                'min:6',
                'confirmed'
            ]
        ];

        return $rules;
    }
}