<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    public function authorize()
    {
        return true;  // Set this to true to allow the request
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:projects,name',  
            'status' => 'required|string|in:active,inactive',           
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'status.required' => 'The status field is required.',
            'status.in' => 'The status must be either active or inactive.',
        ];
    }
}
