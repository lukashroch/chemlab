<?php namespace ChemLab\Http\Requests;

class BrandRequest extends Request
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
            'name' => 'required|min:3|max:255|unique:brands,name',
            'pattern' => 'max:255',
            'description' => 'max:255',
        ];

        if ($this->method() == 'PATCH') {
            $rules['name'] .= ',' . $this->segment(2);
        }

        return $rules;
    }
}
