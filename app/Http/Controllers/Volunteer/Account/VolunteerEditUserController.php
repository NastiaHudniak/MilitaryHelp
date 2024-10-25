<?php

namespace App\Http\Controllers\Volunteer\Account;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class VolunteerEditUserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->get();
        $roles = Role::all();
        return view('user.volunteer.edit_account', compact('users', 'roles'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('user.volunteer.edit_account', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $isLoginChanged = $user->login !== $request->input('login');

        $validated1 = $request->validate([
            'login' => [
                'required',
                'string',
                'max:255',
                $isLoginChanged ? 'unique:users,login' : 'nullable',
            ],
            'surname' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user->update([
            'login' => $validated1['login'] ?? $user->login,
            'surname' => $validated1['surname'],
            'name' => $validated1['name'],
            'email' => $validated1['email'],
            'phone' => $validated1['phone'],
            'address' => $validated1['address'],
            'role_id' => $validated1['role_id'],
        ]);

        return redirect()->route('user.volunteer.index')->with('success', 'Данні користувача оновлено успішно !!!');
    }
}
