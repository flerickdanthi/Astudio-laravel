<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Timesheet;
use App\Http\Requests\CreateProjectRequest;
use Illuminate\Support\Facades\Validator;




class ProjectController extends Controller
{
    // Create a new Project
    public function store(StoreProjectRequest $request)
    {
        $project = Project::create($request->validated());

        return response()->json($project, 201);
    }

    // Update an existing Project
    public function update(StoreProjectRequest $request, $id)
    {
        $project = Project::findOrFail($id);
        $project->update($request->validated());

        return response()->json($project);
    }

    // Get all Projects
        // public function index()
        // {
        //     $projects = Project::all();
        //     return response()->json($projects);
        // }

    // Get a single Project
    public function show($id)
    {
        $project = Project::findOrFail($id);
        return response()->json($project);
    }

    // Delete a Project
    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return response()->json(['message' => 'Project deleted successfully']);
    }


    //Set Attribute Values for Projects
    public function setDynamicProjectAttribute(Request $request)
    {
        $project = Project::create($request->all());

        // Set dynamic attribute values
        foreach ($request->input('attributes', []) as $attributeData) {
            $attribute = Attribute::find($attributeData['id']);
            if ($attribute) {
                AttributeValue::create([
                    'attribute_id' => $attribute->id,
                    'entity_id' => $project->id,
                    'value' => $attributeData['value'],
                ]);
            }
        }

        return response()->json($project, 201);
    }

    public function updateDynamicProjectAttribute(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        $project->update($request->all());

        // Update dynamic attribute values
        foreach ($request->input('attributes', []) as $attributeData) {
            $attributeValue = AttributeValue::where('entity_id', $project->id)
                ->where('attribute_id', $attributeData['id'])
                ->first();

            if ($attributeValue) {
                $attributeValue->update([
                    'value' => $attributeData['value'],
                ]);
            } else {
                AttributeValue::create([
                    'attribute_id' => $attributeData['id'],
                    'entity_id' => $project->id,
                    'value' => $attributeData['value'],
                ]);
            }
        }

        return response()->json($project, 200);
    }

    //Fetch Projects with Dynamic Attributes

    public function fetchDyamicAttribute($id)
    {
        $project = Project::with('attributeValues.attribute')->findOrFail($id);
        return response()->json($project);
    }


    //Filter Projects by Dynamic Attributes
    public function filterProjects(Request $request)
    {
        $query = Project::query();
        
        $filters = $request->input('filters', []);
        
        foreach ($filters as $filter) {
            $query->whereHas('attributes', function ($q) use ($filter) {
                $q->where('attribute_values.attribute_id', $filter['attribute_id'])
                  ->where('attribute_values.value', $filter['value']);
            });
        }
        
        $projects = $query->get();

        return response()->json($projects);
    }

    public function index(Request $request)
    {
    $query = Project::query();

    $filters = $request->input('filters', []);

    foreach ($filters as $key => $value) {
        if (in_array($key, ['name', 'status'])) {
            $this->applyRegularFilter($query, $key, $value);
        } else {
            $this->applyEavFilter($query, $key, $value);
        }
    }

    $projects = $query->with(['attributeValues.attribute'])->get();

    return response()->json($projects);
    }

    private function applyRegularFilter($query, $key, $value)
    {
    if (strpos($value, ':') !== false) {
        list($operator, $value) = explode(':', $value, 2);
        if ($operator == 'LIKE') {
            $query->where($key, 'LIKE', '%' . $value . '%');
        } elseif ($operator == '>') {
            $query->where($key, '>', $value);
        } elseif ($operator == '<') {
            $query->where($key, '<', $value);
        } else {
            $query->where($key, '=', $value);
        }
    } else {
        $query->where($key, '=', $value);
    }
    }

    private function applyEavFilter($query, $key, $value)
    {
    if (strpos($value, ':') !== false) {
        list($operator, $value) = explode(':', $value, 2);
        $this->applyEavFilterOperator($query, $key, $value, $operator);
    } else {
        $query->whereHas('attributeValues', function ($q) use ($key, $value) {
            $q->where('attribute_values.value', '=', $value)
              ->whereHas('attribute', function ($query) use ($key) {
                  $query->where('attributes.name', '=', $key);
              });
        });
    }
    }

    private function applyEavFilterOperator($query, $key, $value, $operator)
    {
    $query->whereHas('attributeValues', function ($q) use ($key, $value, $operator) {
        switch ($operator) {
            case 'LIKE':
                $q->where('attribute_values.value', 'LIKE', '%' . $value . '%');
                break;
            case '>':
                $q->where('attribute_values.value', '>', $value);
                break;
            case '<':
                $q->where('attribute_values.value', '<', $value);
                break;
            default:
                $q->where('attribute_values.value', '=', $value);
                break;
        }

        // Filter by attribute name
        $q->whereHas('attribute', function ($query) use ($key) {
            $query->where('attributes.name', '=', $key);
        });
    });
}



public function getstore(Request $request)
{
    // Validate the incoming request data
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'status' => 'required|string|max:255',
        'attributes' => 'array',
        'attributes.*.name' => 'required|string|exists:attributes,name',
        'attributes.*.value' => 'required|string',
        'timesheets' => 'array',
        'timesheets.*.task_name' => 'required|string',
        'timesheets.*.date' => 'required|date_format:Y-m-d',
        'timesheets.*.hours' => 'required|numeric|min:0',
    ]);

    // If validation fails, return validation errors
    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // Get validated data
    $validated = $validator->validated();

    // Create the project
    $project = Project::create([
        'name' => $validated['name'],
        'status' => $validated['status'],
    ]);

    // Store project attributes dynamically
    $attributeValues = [];
    foreach ($validated['attributes'] as $attribute) {
        $attributeRecord = Attribute::where('name', $attribute['name'])->first();

        if ($attributeRecord) {
            $attributeValue = AttributeValue::create([
                'attribute_id' => $attributeRecord->id,
                'entity_id' => $project->id,
                'value' => $attribute['value'],
            ]);
            $attributeValues[] = $attributeValue;
        }
    }

    // Store timesheets and gather the created records
    $timesheets = [];
    foreach ($validated['timesheets'] as $timesheet) {
        $timesheetRecord = Timesheet::create([
            'task_name' => $timesheet['task_name'],
            'date' => $timesheet['date'],
            'hours' => $timesheet['hours'],
            'project_id' => $project->id,
            'user_id' => auth()->id(), // Assuming the user is authenticated
        ]);
        $timesheets[] = $timesheetRecord;
    }

    // Return a response with all the relevant data
    return response()->json([
        'message' => 'Project created successfully!',
        'project' => $project,
        'attributes' => $attributeValues,
        'timesheets' => $timesheets,
    ], 201);
}

public function getupdate($id, Request $request)
{
    // Validate the incoming request data
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'status' => 'required|string|max:255',
        'attributes' => 'array',
        'attributes.*.name' => 'required|string|exists:attributes,name',
        'attributes.*.value' => 'required|string',
        'timesheets' => 'array',
        'timesheets.*.task_name' => 'required|string',
        'timesheets.*.date' => 'required|date_format:Y-m-d',
        'timesheets.*.hours' => 'required|numeric|min:0',
    ]);

    // If validation fails, return validation errors
    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // Get validated data
    $validated = $validator->validated();

    // Find the project to update
    $project = Project::find($id);

    // If project doesn't exist, return error
    if (!$project) {
        return response()->json(['message' => 'Project not found'], 404);
    }

    // Update the project details
    $project->update([
        'name' => $validated['name'],
        'status' => $validated['status'],
    ]);

    // Remove existing attribute values to update them
    // We assume that each project can have multiple dynamic attributes
    AttributeValue::where('entity_id', $project->id)->delete();

    // Store updated project attributes dynamically
    $attributeValues = [];
    foreach ($validated['attributes'] as $attribute) {
        $attributeRecord = Attribute::where('name', $attribute['name'])->first();

        if ($attributeRecord) {
            $attributeValue = AttributeValue::create([
                'attribute_id' => $attributeRecord->id,
                'entity_id' => $project->id,
                'value' => $attribute['value'],
            ]);
            $attributeValues[] = $attributeValue;
        }
    }

    // Update or create new timesheets
    $timesheets = [];
    foreach ($validated['timesheets'] as $timesheet) {
        // Find the existing timesheet if it exists
        $existingTimesheet = Timesheet::where('task_name', $timesheet['task_name'])
                                      ->where('project_id', $project->id)
                                      ->where('date', $timesheet['date'])
                                      ->first();

        if ($existingTimesheet) {
            // If the timesheet exists, update it
            $existingTimesheet->update([
                'hours' => $timesheet['hours'],
            ]);
            $timesheets[] = $existingTimesheet;
        } else {
            // If no existing timesheet, create a new one
            $newTimesheet = Timesheet::create([
                'task_name' => $timesheet['task_name'],
                'date' => $timesheet['date'],
                'hours' => $timesheet['hours'],
                'project_id' => $project->id,
                'user_id' => auth()->id(), // Assuming the user is authenticated
            ]);
            $timesheets[] = $newTimesheet;
        }
    }

    // Return a response with all the relevant data
    return response()->json([
        'message' => 'Project updated successfully!',
        'project' => $project,
        'attributes' => $attributeValues,
        'timesheets' => $timesheets,
    ], 200);
}


}