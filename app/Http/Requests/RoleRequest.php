<?php namespace ChemLab\Http\Requests;

use Illuminate\Validation\Rule;

class RoleRequest extends Request
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
            'name' => 'sometimes|required|string|min:3|max:255|unique:roles,name',
            'display_name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                Rule::unique('roles', 'display_name')->ignore($this->route('role') ? $this->route('role')->id : null)
            ],
            'description' => 'max:255'
        ];

        return $rules;
    }
}
