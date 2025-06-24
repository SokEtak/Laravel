<?php

namespace App\Http\Controllers;

use App\Http\Requests\users\StoreUserRequest;
use App\Models\OrderDetail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();

        // Hash the password before saving
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        User::create($data);

        return redirect()->route('users.index')->with('success', 'User created successfully');
    }

    public function show($id)
    {
        try {
            $user = User::findOrFail($id);
            $orders = OrderDetail::where('user_id', $id)->get()->toArray();
            return view('users.show', compact('user', 'orders'));
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('error', 'User not found');
        }
    }

//    public function edit($id)
//    {
//        try {
//            $user = User::findOrFail($id);
//            return view('users.edit', compact('user'));
//        } catch (\Exception $e) {
//            return redirect()->route('users.index')->with('error', 'User not found');
//        }
//    }
//
//    public function update(StoreUserRequest $request, $id)
//    {
//        try {
//            $user = User::findOrFail($id);
//            // Validate the request data
//            $data = $request->validated();
//
//            if (!empty($data['password'])) {
//                $data['password'] = Hash::make($data['password']);
//            } else {
//                unset($data['password']); // Don't update password if not provided
//            }
//
//            $user->update($data);
//
//            return redirect()->route('users.index')->with('success', 'User updated successfully');
//        } catch (\Exception $e) {
//            return redirect()->route('users.index')->with('error', 'Failed to update user');
//        }
//    }

//    public function destroy($id)
//    {
//        try {
//            $user = User::findOrFail($id);
//            $user->delete();
//
//            return redirect()->route('users.index')->with('success', 'User deleted successfully');
//        } catch (\Exception $e) {
//            return redirect()->route('users.index')->with('error', 'Failed to delete user');
//        }
//    }
}
