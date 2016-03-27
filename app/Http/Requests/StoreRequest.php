<?php namespace ChemLab\Http\Requests;

class StoreRequest extends Request
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
        return [
            'name' => 'required|min:3|max:255',
            'abbr_name' => 'min:3|max:255',
            'temp_min' => 'numeric',
            'temp_max' => 'numeric',
        ];
    }
}
