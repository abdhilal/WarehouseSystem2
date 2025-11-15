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
            'area_ids' => 'required|array|min:1',
            'area_ids.*' => 'exists:areas,id',
        ];
    }
}
