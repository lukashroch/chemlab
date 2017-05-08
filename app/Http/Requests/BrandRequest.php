<?php

namespace ChemLab\Http\Requests;

use Illuminate\Validation\Rule;

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
            'name' => [
                'string',
                'required',
                'min:3',
                'max:255',
                Rule::unique('brands', 'name')->ignore($this->route('brand') ? $this->route('brand')->id : null)],
            'url_product' => 'string:max:255',
            'url_sds' => 'string:max:255',
            'parse_callback' => 'string:max:255',
            'description' => 'max:255'
        ];

        return $rules;
    }
}
