<?php

namespace ChemLab\Http\Requests;

use Illuminate\Validation\Rule;

class PermissionRequest extends Request
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
                'sometimes',
                'required',
                'string',
                'min:3',
                'max:255',
                Rule::unique('permissions', 'name')->ignore($this->route('permission') ? $this->route('permission')->id : null)
            ],
            'display_name' => [
                'required',
                'string',
                'min:3',
                'max:150',
                Rule::unique('permissions', 'display_name')->ignore($this->route('permission') ? $this->route('permission')->id : null)
            ],
            'description' => 'string|nullable|max:255'
        ];
    }
}
