<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'productName' => 'required|string|max:50',
            'productCategory' => 'required|string|max:25',
            'productPrice' => 'required|numeric|integer|gt:0',
            'productQuantity' => 'required|numeric|integer|gte:1',
            'productMeasurement' => 'required|string|max:50',
            'productDescription' => 'required|string|max:1000',
            // 'productAddress' => 'required|string',
            // 'productCity' => 'required|string',
            // 'productState' => 'required|string',
            'productFrontView' => 'nullable|file|image|max:4096',
            'productBackView' => 'nullable|file|image|max:4096',
            'productLeftView' => 'nullable|file|image|max:4096',
            'productRightView' => 'nullable|file|image|max:4096',

        ];
    }
}