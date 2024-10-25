<?php

namespace App\Http\Controllers\Military;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class MilitaryViewVolunteerController extends Controller
{
    public function index()
    {
        // Отримати тільки волонтерів, де role_id = 3
        $volunteers = User::where('role_id', 3)->with('role')->get();

        // Якщо хочете отримати також усі ролі для фільтрації чи іншої мети
        $roles = Role::all();

        // Повернути вид з волонтерами та ролями
        return view('user.military.view_volunteer', compact('volunteers', 'roles'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login' => 'required|unique:users|max:255',
            'surname' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'role_id' => 'required|exists:roles,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        User::create([
            'login' => $request->input('login'),
            'surname' => $request->input('surname'),
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'role_id' => $request->input('role_id'),
        ]);

        return redirect()->route('user.military.view_volunteer')->with('success', 'Користувач створений успішно !!!');
    }
}
