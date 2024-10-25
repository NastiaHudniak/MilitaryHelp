<?php

namespace App\Http\Controllers\Military\Account;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class MilitaryEditAccountController extends Controller
{
    public function index()
    {
        $users = User::with('role')->get();
        $roles = Role::all();
        return view('user.military.edit_account', compact('users', 'roles'));
    }

//    public function create()
//    {
//        $roles = Role::all();
//        return view('admin.users.create', compact('roles'));
//    }

//    public function store(Request $request)
//    {
//        $validator = Validator::make($request->all(), [
//            'login' => 'required|unique:users|max:255',
//            'surname' => 'required|string|max:255',
//            'name' => 'required|string|max:255',
//            'email' => 'required|email|unique:users,email',
//            'password' => 'required|string|min:8|confirmed',
//            'phone' => 'required|string|max:255',
//            'address' => 'required|string|max:255',
//            'role_id' => 'required|exists:roles,id',
//        ]);
//
//        if ($validator->fails()) {
//            return redirect()->back()->withErrors($validator)->withInput();
//        }
//
//        User::create([
//            'login' => $request->input('login'),
//            'surname' => $request->input('surname'),
//            'name' => $request->input('name'),
//            'email' => $request->input('email'),
//            'password' => Hash::make($request->input('password')),
//            'phone' => $request->input('phone'),
//            'address' => $request->input('address'),
//            'role_id' => $request->input('role_id'),
//        ]);
//
//        return redirect()->route('user.military.index')->with('success', 'Користувач створений успішно !!!');
//    }


    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('user.military.edit_account', compact('user', 'roles'));
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

        return redirect()->route('user.military.index')->with('success', 'Данні користувача оновлено успішно !!!');
    }
}
