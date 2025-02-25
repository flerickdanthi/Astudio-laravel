<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TimesheetController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\AttributeValueController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Register Route
Route::post('register', [AuthController::class, 'register']);

// Login Route
Route::post('login', [AuthController::class, 'login']);

// Logout Route
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');

// User Route (to get the authenticated user)
Route::get('user', [AuthController::class, 'user'])->middleware('auth:api');


Route::middleware('auth:api')->group(function () {

    // User Routes
    Route::get('users', [UserController::class, 'index']);  // Get all users
    Route::get('users/{id}', [UserController::class, 'show']);  // Get a user by ID
    Route::delete('users/{id}', [UserController::class, 'destroy']);  // Delete user
    Route::get('users/test/{id}',[UserController::class, 'getUserData']);

    // Project Routes
    Route::get('projects/{id}', [ProjectController::class, 'show']);  // Get a project by ID
    Route::post('projects', [ProjectController::class, 'store']);  // Create a new project
    Route::put('projects/{id}', [ProjectController::class, 'update']);  // Update project
    Route::delete('projects/{id}', [ProjectController::class, 'destroy']);  // Delete project

    // Timesheet Routes
    Route::get('timesheets', [TimesheetController::class, 'index']);  // Get all timesheets
    Route::get('timesheets/{id}', [TimesheetController::class, 'show']);  // Get a timesheet by ID
    Route::post('timesheets', [TimesheetController::class, 'store']);  // Create a new timesheet
    Route::put('timesheets/{id}', [TimesheetController::class, 'update']);  // Update timesheet
    Route::delete('timesheets/{id}', [TimesheetController::class, 'destroy']);  // Delete timesheet

    // Attribute Routes 
    Route::get('attributes', [AttributeController::class, 'index']);  // Get all attributes
    Route::get('attributes/{id}', [AttributeController::class, 'show']);  // Get an attribute by ID
    Route::post('attributes', [AttributeController::class, 'store']);  // Create a new attribute
    Route::put('attributes/{id}', [AttributeController::class, 'update']);  // Update attribute
    Route::delete('attributes/{id}', [AttributeController::class, 'destroy']);  // Delete attribute

    // Attribute Value Routes 
    Route::post('attribute-values', [AttributeValueController::class, 'store']);  // Set attribute value for project
    Route::get('attribute-values', [AttributeValueController::class, 'index']);  // Get all attribute values
    Route::get('attribute-values/{id}', [AttributeValueController::class, 'show']);  // Get an attribute value by ID
    Route::put('attribute-values/{id}', [AttributeValueController::class, 'update']);  // Update attribute value
    Route::delete('attribute-values/{id}', [AttributeValueController::class, 'destroy']);  // Delete attribute value


    Route::post('set-dynamic-attribute-projects', [ProjectController::class, 'setDynamicProjectAttribute']);
    Route::put('update-dynamic-attribute-projects/{project_id}', [ProjectController::class, 'updateDynamicProjectAttribute']);
    Route::get('fetch-dynamic-attribute-projects/{project_id}', [ProjectController::class, 'fetchDyamicAttribute']);


    //Filter
    Route::get('projects', [ProjectController::class, 'index']);  // Get all projects
    Route::post('createproject', [ProjectController::class, 'getstore']);
    Route::put('updateproject/{id}', [ProjectController::class, 'getupdate']);



});


