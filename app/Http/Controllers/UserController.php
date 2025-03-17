<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Contracts\Role;
use Spatie\Permission\Models\Role as ModelsRole;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $data = User::latest()->paginate(5);
        return view('users.show_users', compact('data'));
    }

    public function create()
    {
        $roles = ModelsRole::pluck('name', 'name')->all();
        return view('users.add_user', compact('roles'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles_name' => 'required'
        ]);
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles_name'));
        return redirect()->route('users.view')
            ->with('success', 'User added successfully');
    }

    public function show($id)
    {
        $user = User::find($id);
        return view('users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::find($id);
        $roles = ModelsRole::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();
        return view('users.edit', compact('user', 'roles', 'userRole'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'roles' => 'required',
        ];
        if ($request->filled('password')) {
            $rules['password'] = 'required|same:confirm-password|min:8';
        }
        $request->validate($rules);

        $input = $request->except(['confirm-password']);
        if ($request->filled('password')) {
            $input['password'] = Hash::make($input['password']);
        }
        $user = User::findOrFail($id);
        $user->update($input);

        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $user->assignRole($request->input('roles'));

        return redirect()->route('users.view')
            ->with('success', 'User information updated successfully');
    }

    public function destroy(Request $request)
    {
        User::find($request->user_id)->delete();
        return redirect()->route('users.view')->with('success', 'User deleted successfully');
    }
}
