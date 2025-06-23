<?php

namespace App\Http\Controllers\Military\Account;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MilitaryEditUserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->get();
        $roles = Role::all();
        return view('user.military.edit_account', compact('users', 'roles'));
    }

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

        $messages = [
            'login.required' => '* Обов’язкове поле.',
            'login.string' => '* Логін має бути рядком.',
            'login.max' => '* Логін не може бути довшим за 255 символів.',
            'login.unique' => '* Такий логін вже існує.',

            'surname.required' => '* Обов’язкове поле.',
            'surname.string' => '* Прізвище має бути рядком.',
            'surname.max' => '* Прізвище не може бути довшим за 255 символів.',

            'name.required' => '* Обов’язкове поле.',
            'name.string' => '* Ім’я має бути рядком.',
            'name.max' => '* Ім’я не може бути довшим за 255 символів.',

            'email.required' => '* Обов’язкове поле.',
            'email.email' => '* Невірний формат електронної пошти.',
            'email.unique' => '* Такий email вже використовується.',

            'phone.required' => '* Обов’язкове поле.',
            'phone.string' => '* Телефон має бути рядком.',
            'phone.max' => '* Телефон не може бути довшим за 255 символів.',

            'address.required' => '* Обов’язкове поле.',
            'address.string' => '* Адреса має бути рядком.',
            'address.max' => '* Адреса не може бути довшою за 255 символів.',

            'role_id.required' => '* Оберіть роль.',
            'role_id.exists' => '* Обрана роль не існує.',
        ];

        $rules = [
            'login' => array_filter([
                'required',
                'string',
                'max:255',
                $isLoginChanged ? 'unique:users,login' : null,
            ]),
            'surname' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'role_id' => 'required|exists:roles,id',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $validated = $validator->validated();

        $user->update([
            'login' => $validated['login'] ?? $user->login,
            'surname' => $validated['surname'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'role_id' => $validated['role_id'],
        ]);

        return redirect()->route('user.military.index')->with('success', 'Дані користувача оновлено успішно!');
    }
}
