<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAttributeValueRequest;
use App\Http\Requests\UpdateAttributeValueRequest;
use App\Models\AttributeValue;
use Illuminate\Http\Request;

class AttributeValueController extends Controller
{
    // Create a new Attribute Value
    public function store(StoreAttributeValueRequest $request)
    {
        $attributeValue = AttributeValue::create($request->validated());

        return response()->json($attributeValue, 201);
    }

    // Update an existing Attribute Value
    public function update(StoreAttributeValueRequest $request, $id)
    {
        $attributeValue = AttributeValue::findOrFail($id);
        $attributeValue->update($request->validated());

        return response()->json($attributeValue);
    }

    // Get all Attribute Values
    public function index()
    {
        $attributeValues = AttributeValue::all();
        return response()->json($attributeValues);
    }

    // Get a single Attribute Value
    public function show($id)
    {
        $attributeValue = AttributeValue::findOrFail($id);
        return response()->json($attributeValue);
    }

    // Delete an Attribute Value
    public function destroy($id)
    {
        $attributeValue = AttributeValue::findOrFail($id);
        $attributeValue->delete();

        return response()->json(['message' => 'Attribute Value deleted successfully']);
    }
}
