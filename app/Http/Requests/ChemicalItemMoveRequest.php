<?php

namespace ChemLab\Http\Requests;

class ChemicalItemMoveRequest extends Request
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
            'items' => 'required|array|exists:chemical_items,id',
            'store_id' => 'required|integer|exists:stores,id',
        ];
    }
}
