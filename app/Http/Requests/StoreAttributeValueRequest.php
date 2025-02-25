<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAttributeValueRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'attribute_id' => 'required|exists:attributes,id',
            'entity_id' => 'required|exists:projects,id', 
            'value' => 'required|string',
        ];
    }
}
