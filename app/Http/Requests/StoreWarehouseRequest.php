<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Warehouse;

class StoreWarehouseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {

        return $this->user()->hasPermissionTo('create-warehouse');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:150',
            'location' => 'required|string|max:255',

        ];
    }



    public function messages(): array
    {
        return [

            'name.required' => __('Name is required'),
            'name.string' => __('Name must be a string'),
            'name.max' => __('Name must be at most 150 characters'),
            'location.required' => __('Location is required'),
            'location.string' => __('Location must be a string'),
            'location.max' => __('Location must be at most 255 characters'),
        ];
    }
}
