<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() ? $this->user()->hasPermissionTo('create-user') : false;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:150',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
            'warehouse_id' => 'nullable|exists:warehouses,id',
        ];
    }
}
