<?php namespace ChemLab\Http\Requests;

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
            'name' => 'required|min:3|max:255',
            'iupac_name' => 'max:255',
            'brand_id' => 'numeric',
            'brand_no' => 'max:255',
            'cas' => 'max:255',
            'chemspider' => 'max:255',
            'pubchem' => 'max:255',
            'mw' => 'numeric',
            'formula' => 'max:255',
            'synonym' => 'max:255',
            'description' => 'max:255',
            'h_symbol' => 'max:255',
            'signal_word' => 'max:255',
            'h_statement' => 'max:255',
            'p_statement' => 'max:255'
        ];

        return $rules;
    }
}
