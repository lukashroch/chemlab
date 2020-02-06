<?php

namespace ChemLab\Http\Requests;

use Illuminate\Validation\Rule;

class ProfileRequest extends Request
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
        $rules = [
            'key' => [
                'required',
                Rule::in(['lang', 'listing']),
            ]
        ];
        switch ($this->input('key')) {
            case 'lang':
                $rules['value'] = 'string';
                break;
            case 'listing':
                $rules['value'] = 'integer';
                break;
            default:
                break;
        }

        return $rules;
    }
}
