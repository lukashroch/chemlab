<?php

namespace ChemLab\Http\Requests;

use Illuminate\Validation\Rule;

class CategoryRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => [
                'string',
                'required',
                'min:3',
                'max:255',
                Rule::unique('categories', 'name')->ignore($this->route('category') ? $this->route('category')->id : null)
            ],
            'description' => 'max:255|nullable'
        ];
    }
}
