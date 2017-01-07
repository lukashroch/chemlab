<?php namespace ChemLab\Http\Requests;

use Illuminate\Validation\Rule;

class StoreRequest extends Request
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
                    })],
            'abbr_name' => 'string|max:255',
            'temp_min' => 'required|integer',
            'temp_max' => 'required|integer',
        ];
    }
}
