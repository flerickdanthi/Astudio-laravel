<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTimesheetRequest;
use App\Http\Requests\UpdateTimesheetRequest;
use App\Models\Timesheet;
use Illuminate\Http\Request;

class TimesheetController extends Controller
{
    // Create a new Timesheet
    public function store(StoreTimesheetRequest $request)
    {
        $timesheet = Timesheet::create($request->validated());

        return response()->json($timesheet, 201);
    }

    // Update an existing Timesheet
    public function update(StoreTimesheetRequest $request, $id)
    {
        $timesheet = Timesheet::findOrFail($id);
        $timesheet->update($request->validated());

        return response()->json($timesheet);
    }

    // Get all Timesheets
    public function index()
    {
        $timesheets = Timesheet::all();
        return response()->json($timesheets);
    }

    // Get a single Timesheet
    public function show($id)
    {
        $timesheet = Timesheet::findOrFail($id);
        return response()->json($timesheet);
    }

    // Delete a Timesheet
    public function destroy($id)
    {
        $timesheet = Timesheet::findOrFail($id);
        $timesheet->delete();

        return response()->json(['message' => 'Timesheet deleted successfully']);
    }
}
