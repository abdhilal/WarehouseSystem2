<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePharmacyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() ? $this->user()->hasPermissionTo('edit-pharmacy') : false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $pharmacyId = $this->route('pharmacy')?->id;
        return [
            'name' => 'required|string|max:150|unique:pharmacies,name,' . $pharmacyId,
            'area_id' => 'required|exists:areas,id',
            'representative_id' => 'nullable|exists:representatives,id',
            'warehouse_id' => 'required|exists:warehouses,id',
        ];
    }
}
