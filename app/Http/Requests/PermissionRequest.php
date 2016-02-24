<?php namespace ChemLab\Http\Requests;

class PermissionRequest extends Request
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
            'name' => 'required|min:3|max:255|unique:permissions,name',
            'display_name' => 'required|min:3|max:255|unique:permissions,display_name',
            'description' => 'max:255'
        ];

        if ($this->method() == 'PATCH') {
            $rules = [
                'display_name' => 'required|min:3|max:255|unique:permissions,display_name,' . $this->segment(2),
                'description' => 'max:255',
            ];
        }

        return $rules;
    }
}
