<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRepresentativeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() ? $this->user()->hasPermissionTo('create-representative') : false;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:150',
            'area_id' => 'required|exists:areas,id',
            'warehouse_id' => 'required|exists:warehouses,id',
        ];
    }
}
