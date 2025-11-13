<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() ? $this->user()->hasPermissionTo('edit-product') : false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $productId = $this->route('product')?->id;
        return [
            'name' => 'required|string|max:150|unique:products,name,' . $productId,
            'factory_id' => 'required|exists:factories,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'unit_price' => 'nullable|numeric|min:0',
        ];
    }
}
