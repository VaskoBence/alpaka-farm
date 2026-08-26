<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $slug = Str::slug(
            (string) $this->input('name')
        );

        $this->merge([
            'slug' => $slug !== ''
                ? $slug
                : null,
        ]);
    }

    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:150',
                'regex:/[\pL\pN]/u',
                'unique:products,name',
            ],

            'slug' => [
                Rule::requiredIf(
                    fn (): bool =>
                        preg_match(
                            '/[\pL\pN]/u',
                            (string) $this->input('name')
                        ) === 1
                ),
                'nullable',
                'string',
                'max:255',
                'unique:products,slug',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],

            'description' => [
                'nullable',
                'string',
                'max:2000',
            ],

            'price' => [
                'required',
                'integer',
                'min:0',
            ],

            'stock' => [
                'required',
                'integer',
                'min:0',
            ],

            'is_active' => [
                'sometimes',
                'boolean',
            ],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.regex' =>
                'A terméknévnek legalább egy betűt vagy számot tartalmaznia kell.',

            'slug.required' =>
                'A terméknévből nem készíthető érvényes webcím.',

            'slug.unique' =>
                'Ebből a terméknévből már létezik azonos webcím.',
        ];
    }
}