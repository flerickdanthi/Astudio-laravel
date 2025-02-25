<?php

namespace App\Http\Controllers; // The namespace declaration should be at the top

use App\Models\User; // Then you can add your use statements

class UserController extends Controller

{
    // Fetch all user data based on user_id
    public function getUserData($userId)
    {
        // Find the user by user_id
        $user = User::with([
            'projects',             
            'timesheets.project',   
            'projects.attributeValues', 
        ])->findOrFail($userId);

        // Return the user data with related data
        return response()->json([
            'user' => $user
        ]);
    }
    /**
     * Display a listing of all users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get all users from the database
        $users = User::all();

        // Return a JSON response with users
        return response()->json($users, 200);
    }

    /**
     * Display the specified user by ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Find user by ID
        $user = User::find($id);

        if ($user) {
            // Return user details in JSON format
            return response()->json($user, 200);
        } else {
            // If user not found, return a 404 response
            return response()->json(['message' => 'User not found'], 404);
        }
    }

    /**
     * Remove the specified user from the database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find user by ID
        $user = User::find($id);

        if ($user) {
            // Delete the user
            $user->delete();

            // Return a success message
            return response()->json(['message' => 'User deleted successfully'], 200);
        } else {
            // If user not found, return a 404 response
            return response()->json(['message' => 'User not found'], 404);
        }
    }
}
