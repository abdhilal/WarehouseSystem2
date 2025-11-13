<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePharmacyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() ? $this->user()->hasPermissionTo('create-pharmacy') : false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:150|unique:pharmacies,name',
            'area_id' => 'required|exists:areas,id',
            'representative_id' => 'nullable|exists:users,id',
            'warehouse_id' => 'required|exists:warehouses,id',
        ];
    }
}
