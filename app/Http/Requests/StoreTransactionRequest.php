<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() ? $this->user()->hasPermissionTo('create-transaction') : false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'warehouse_id' => 'required|exists:warehouses,id',
            'factory_id' => 'required|exists:factories,id',
            'pharmacy_id' => 'required|exists:pharmacies,id',
            'representative_id' => 'required|exists:representatives,id',
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:Wholesale Sale,Wholesale Return,Gift',
            'quantity' => 'required|integer|min:0',
            'value' => 'nullable|numeric|min:0',
            'gift_value' => 'nullable|numeric|min:0',
            'quantity_gift' => 'nullable|integer|min:0',
            'value_output' => 'nullable|numeric|min:0',
        ];
    }
}
