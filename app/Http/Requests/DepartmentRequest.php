<?php namespace ChemLab\Http\Requests;

class DepartmentRequest extends Request
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
            'name' => 'required|min:3|max:255|unique:departments,name',
            'prefix' => 'required|min:2|max:255|unique:departments,prefix',
        ];

        if ($this->method() == 'PATCH') {
            $rules['name'] .= ',' . $this->segment(2);
            $rules['prefix'] .= ',' . $this->segment(2);
        }

        return $rules;
    }
}
