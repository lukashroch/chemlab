<?php namespace ChemLab\Http\Requests;

use Illuminate\Validation\Rule;

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
            'iupac_name' => 'string|max:255',
            'brand_id' => [
                'required',
                'integer',
                Rule::in([0, $this->get('brand_id')])
            ],
            'brand_no' => 'string|max:255',
            'cas' => 'string|max:255',
            'chemspider' => 'string|max:255',
            'pubchem' => 'string|max:255',
            'mw' => 'numeric',
            'formula' => 'string|max:255',
            'synonym' => 'string|max:255',
            'description' => 'max:255',
            'symbol' => 'array',
            'signal_word' => 'string|max:255',
            'h' => 'array',
            'p' => 'array',
            'r' => 'array',
            's' => 'array',
        ];

        return $rules;
    }
}
