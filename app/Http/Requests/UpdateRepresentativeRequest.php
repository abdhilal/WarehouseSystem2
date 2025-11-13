<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRepresentativeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() ? $this->user()->hasPermissionTo('edit-representative') : false;
    }

    public function rules(): array
    {
        $userId = $this->route('representative')?->id;
        return [
            'name' => 'required|string|max:150',
            'email' => 'required|email|unique:users,email,' . $userId,
            'password' => 'nullable|confirmed|min:8',
            'warehouse_id' => 'nullable|exists:warehouses,id',
            'area_id' => 'nullable|exists:areas,id',
        ];
    }
}