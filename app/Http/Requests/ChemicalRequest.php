<?php

namespace ChemLab\Http\Requests;

class ChemicalRequest extends Request
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
            'name' => 'required|string|min:3|max:255',
            'iupac_name' => 'string|max:255|nullable',
            'brand_id' => 'exists:brands,id|nullable',
            'catalog_id' => 'string|max:255|nullable',
            /*'catalog_id' => [
                'string',
                'max:255',
                'nullable',
                Rule::unique('chemicals', 'catalog_id')->ignore($this->get('catalog_id'))
                    ->where(function ($query) {
                        $query->where('brand_id', $this->get('brand_id'));
                    })
            ],*/
            'cas' => 'string|max:255|nullable',
            'chemspider' => 'string|max:255|nullable',
            'pubchem' => 'string|max:255|nullable',
            'mw' => 'numeric|nullable',
            'formula' => 'string|max:255|nullable',
            'synonym' => 'string|max:255|nullable',
            'description' => 'max:255|nullable',
            'sds' => 'file|mimes:pdf|mimetypes:application/pdf',
            'symbol' => 'array|nullable',
            'signal_word' => 'string|max:255|nullable',
            'h' => 'array|nullable',
            'p' => 'array|nullable',
            'r' => 'array|nullable',
            's' => 'array|nullable',
        ];

        return $rules;
    }
}
