<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAttributeRequest;
use App\Http\Requests\UpdateAttributeRequest;
use App\Models\Attribute;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    // Create a new Attribute
    public function store(StoreAttributeRequest $request)
    {
        $attribute = Attribute::create($request->validated());

        return response()->json($attribute, 201);
    }

    // Update an existing Attribute
    public function update(StoreAttributeRequest $request, $id)
    {
        $attribute = Attribute::findOrFail($id);
        $attribute->update($request->validated());

        return response()->json($attribute);
    }

    // Get all Attributes
    public function index()
    {
        $attributes = Attribute::all();
        return response()->json($attributes);
    }

    // Get a single Attribute
    public function show($id)
    {
        $attribute = Attribute::findOrFail($id);
        return response()->json($attribute);
    }

    // Delete an Attribute
    public function destroy($id)
    {
        $attribute = Attribute::findOrFail($id);
        $attribute->delete();

        return response()->json(['message' => 'Attribute deleted successfully']);
    }
}
