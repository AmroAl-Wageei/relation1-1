<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all users
        $users = User::all();
        // dd($users); // to check the data
        return view('user.index', compact('users')); // Change 'crud.index' to 'user.index'
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.create'); // Change 'crud.create' to 'user.create'
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
    {
        // Validation rules
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:8|confirmed', // Ensuring password is confirmed
        ]);

        // Create the new user
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password), // Hash the password
        ]);

        return redirect()->route('user.index'); // Change 'crud.index' to 'user.index'
    }


    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // Show user details (optional)
        return view('user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
     public function edit($id)
    {
        // Find the user by ID
        $user = User::findOrFail($id);
        return view('user.edit', compact('user')); // Change 'crud.edit' to 'user.edit'
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validation rules
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Find the user by ID
        $user = User::findOrFail($id);

        // If password is provided, hash it
        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        // Update the user
        $user->update($data);

        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Delete the user
        User::findOrFail($id)->delete();

        return redirect()->route('user.index');
    }
}