<?php namespace ChemLab\Http\Requests;

use ChemLab\Http\Requests\Request;

class ChemicalItemRequest extends Request
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
            'chemical_id' => 'required|numeric',
            'store_id' => 'required|numeric',
            'amount' => 'required|numeric',
            'unit' => 'required|numeric'
        ];

        return $rules;
    }
}
