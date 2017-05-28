<?php

namespace ChemLab\Http\Requests;

class NmrRequest extends Request
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
            'user_id' => 'required|integer|exists:users,id',
            'file' => 'required|file|mimes:zip'
        ];

        return $rules;
    }
}
