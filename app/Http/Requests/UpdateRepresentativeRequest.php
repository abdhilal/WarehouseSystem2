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
            'area_ids' => 'required|array|min:1',
            'area_ids.*' => 'exists:areas,id',
        ];
    }
}
