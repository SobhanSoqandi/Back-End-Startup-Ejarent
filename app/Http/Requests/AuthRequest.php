<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
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
            'phoneNumber' => 'required|string|regex:/^09[0-9]{9}$/',
            'name' => 'required|string|max:255',
            'national_code' => 'nullable|digits:10',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }
}
