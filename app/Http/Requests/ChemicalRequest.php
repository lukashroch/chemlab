<?php

namespace ChemLab\Http\Requests;

use ChemLab\Rules\UniqueBrand;

class ChemicalRequest extends Request
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
            'name' => 'required|string|min:3|max:255',
            'iupac' => 'string|max:255|nullable',
            'brand_id' => 'exists:brands,id|nullable',
            'catalog_id' => [
                'string',
                'max:255',
                'nullable',
                new UniqueBrand($this->input('brand_id'), $this->route('chemical') ? $this->route('chemical')->id : null)
            ],
            'cas' => 'string|max:255|nullable',
            'chemspider' => 'string|max:255|nullable',
            'pubchem' => 'string|max:255|nullable',
            'mw' => 'numeric|nullable',
            'formula' => 'string|max:255|nullable',
            'synonym' => 'string|max:255|nullable',
            'description' => 'max:255|nullable',
            'symbol' => 'array|nullable',
            'signal_word' => 'string|max:255|nullable',
            'h' => 'array|nullable',
            'p' => 'array|nullable',
            'r' => 'array|nullable',
            's' => 'array|nullable',
            'structure' => 'array',
            'structure.inchikey' => 'string|nullable',
            'structure.inchi' => 'string|nullable',
            'structure.smiles' => 'string|nullable',
            'structure.sdf' => 'string|nullable'
        ];
    }
}
