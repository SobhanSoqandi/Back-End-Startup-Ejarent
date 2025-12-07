<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdvertisementStoreRequest extends FormRequest
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
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'images'       => ['nullable'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png', 'max:2048'],


            'attributes'                 => ['nullable', 'array'],
            'attributes.*.id'            => ['required_with:attributes', 'exists:attributes,id'],
            'attributes.*.value'         => ['required_with:attributes'],
        ];
    }
}
