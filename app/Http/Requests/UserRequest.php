<?php namespace ChemLab\Http\Requests;

class UserRequest extends Request
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
            'name' => 'required|min:3|max:255|unique:users,name',
            'email' => 'required|email|max:255|unique:users,email',
        ];

        if ($this->method() == 'PATCH')
            $rules = ['name' => 'required|min:3|max:255|unique:users,name,' . $this->segment(2)];

        return $rules;
    }
}
