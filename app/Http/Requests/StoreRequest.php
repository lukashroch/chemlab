<?php

namespace ChemLab\Http\Requests;

use Illuminate\Validation\Rule;

class StoreRequest extends Request
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
                'required',
                'string',
                'min:3',
                'max:255',
                Rule::unique('stores', 'name')->ignore($this->route('store') ? $this->route('store')->id : null)
                    ->where(function ($query) {
                        if (empty($this->get('parent_id')))
                            $query->whereNull('parent_id');
                        else
                            $query->where('parent_id', $this->get('parent_id'));
                    })
            ],
            'parent_id' => 'exists:stores,id|nullable',
            'team_id' => 'exists:teams,id|nullable',
            'abbr_name' => 'string|max:255|nullable',
            'temp_min' => 'required|integer',
            'temp_max' => 'required|integer',
        ];
    }
}
