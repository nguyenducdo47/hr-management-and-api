<?php
namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Product;
use \Illuminate\Contracts\Validation\Validator;
use \Illuminate\Validation\ValidationException;

class ProductRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'sku' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string',
            'category_id' => 'required|numeric|exists:categories,id',
        ];
    }


    public function messages()
    {
        return [
            'sku.required' => 'The SKU is required.',
            'sku.string' => 'The SKU must be a string.',
            'sku.max' => 'The SKU may not be greater than 255 characters',

            'name.required' => 'The product name is required.',
            'name.string' => 'The product name must be a string.',
            'name.max' => 'The product name may not be greater than 255 characters',

            'slug.required' => 'The slug is required.',
            'slug.string' => 'The slug must be a string.',
            'slug.max' => 'The slug may not be greater than 255 characters.',

            'description.string' => 'The description must be a string.',

            'image.string' => 'The image must be a string.',

            'category_id.exists' => 'The selected category does not exist.',
            'category_id.numeric' => 'The category_id must be a number.',
        ];
    }


    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'status' => false,
            'message' => $validator->errors(),
        ], 400);

        throw new ValidationException($validator, $response);
    }


    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $id = $this->route('id');

            if (Product::where('sku', $this->sku)->where('id', '!=', $id)->exists()) {
                $validator->errors()->add('sku', 'SKU already exists.');
            }

            if (Product::where('slug', $this->slug)->where('id', '!=', $id)->exists()) {
                $validator->errors()->add('slug', 'Slug already exists.');
            }
        });
    }
}
