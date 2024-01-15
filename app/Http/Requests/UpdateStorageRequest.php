<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStorageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:45|' . Rule::unique('items')->ignore($this->item),
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Nama gudang tidak boleh kosong',
            'name.unique' => 'Nama gudang telah digunakan',
            'name.max' => 'Nama gudang tidak boleh melebihi 45 karakter',
        ];
    }
}
