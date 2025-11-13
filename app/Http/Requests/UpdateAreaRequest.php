<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAreaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() ? $this->user()->hasPermissionTo('edit-area') : false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $areaId = $this->route('area')?->id;
        return [
            'name' => 'required|string|max:150|unique:areas,name,' . $areaId,
            'warehouse_id' => 'required|exists:warehouses,id',
        ];
    }
}
