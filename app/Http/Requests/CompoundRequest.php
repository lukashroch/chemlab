<?php

namespace ChemLab\Http\Requests;

class CompoundRequest extends Request
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
            'internal_id' => 'min:1|max:255|unique:compounds,internal_id',
            'owner_id' => 'numeric',
            'name' => 'required|min:3|max:255',
            'mw' => 'numeric',
            'amount' => 'numeric',
            'description' => 'max:255'
        ];

        if ($this->method() == 'PATCH') {
            $rules['internal_id'] .= ',' . $this->segment(2);
        }

        return $rules;
    }
}
