<?php namespace ChemLab\Http\Requests;

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

        if ($this->method() == 'POST') {
            $rules['count'] = 'required|numeric|min:1|max:5';
        }

        return $rules;
    }
}
