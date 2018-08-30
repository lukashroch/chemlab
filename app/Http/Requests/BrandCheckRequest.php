<?php

namespace ChemLab\Http\Requests;

use ChemLab\Rules\UniqueBrand;

class BrandCheckRequest extends Request
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
            'except' => 'exists:chemicals,id|nullable',
            'brand_id' => 'exists:brands,id|nullable',
            'catalog_id' => [
                'string',
                'max:255',
                'nullable',
                new UniqueBrand($this->input('brand_id'), $this->input('except'))
            ]
        ];

        return $rules;
    }
}
