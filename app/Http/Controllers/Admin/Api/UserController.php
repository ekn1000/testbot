<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Laravue\Models\Role;
use App\Laravue\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return $users;
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        $roles = $user->getRoleNames();
        $user -> role = $roles[0];
        return $user;
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
            'role' => 'required'
        ]);
            $user = User::create($request->all());
            $user -> password = Hash::make($request->get('password'));
            $user->save();
            $role = Role::findByName($request->get('role'));
            $user -> assignRole($role);

            return $user;
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'role' => 'required']);
        $user = User::findOrFail($id);
        $user -> update($request->all());
        $role = Role::findByName($request->get('role'));
        $user ->syncRoles($role);
        return $user;
    }

    public function changePassword($id, Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:6'
        ]);
        $user = User::findOrFail($id);
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user -> update([
            'password' => $input['password']
        ]);
        return 'Пароль изменен';
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return $user;
    }
}
