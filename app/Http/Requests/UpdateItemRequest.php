<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateItemRequest extends FormRequest
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
            'category_id' => 'required',
            'description' => 'nullable',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Nama barang tidak boleh kosong',
            'name.unique' => 'Nama barang telah digunakan',
            'name.max' => 'Nama barang tidak boleh melebihi 45 karakter',
        ];
    }
}
