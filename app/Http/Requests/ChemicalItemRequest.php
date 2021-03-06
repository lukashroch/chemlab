<?php

namespace ChemLab\Http\Requests;

class ChemicalItemRequest extends Request
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
            'chemical_id' => 'required|integer|exists:chemicals,id',
            'store_id' => 'required|integer|exists:stores,id',
            'amount' => 'required|numeric',
            'unit' => 'required|integer',
            'owner_id' => 'exists:users,id|nullable',
            'count' => 'sometimes|required|integer|min:1|max:5'
        ];
    }
}
