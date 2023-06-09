<?php

namespace App\Http\Requests;

use App\Rules\IntegerArray;
use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string',
            'body' => 'required|string',
            'category_id' => 'required|integer|numeric',
        ];
    }

    public function messages()
    {
        return [
            'body.required' => "Please enter value for body.",
            'title.string' => "You have to provide string value for the title",
            'category_id.required' => "Please choose the category"
        ];
    }
}
