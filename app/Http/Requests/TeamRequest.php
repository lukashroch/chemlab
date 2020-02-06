<?php

namespace ChemLab\Http\Requests;

use Illuminate\Validation\Rule;

class TeamRequest extends Request
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
                Rule::unique('teams', 'name')->ignore($this->route('team') ? $this->route('team')->id : null)
            ],
            'display_name' => [
                'required',
                'string',
                'min:3',
                'max:150',
                Rule::unique('teams', 'display_name')->ignore($this->route('team') ? $this->route('team')->id : null)
            ],
            'description' => 'string|nullable|max:255'
        ];
    }
}
