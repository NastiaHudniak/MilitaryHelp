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
        $messages = [
            'login.required' => '* Обов`язкове поле.',
            'login.unique' => '* Цей логін уже зайнятий.',
            'login.max' => '* Логін не може містити більше ніж 255 символів.',

            'surname.required' => '* Обов`язкове поле.',
            'surname.string' => '* Прізвище має бути рядком.',
            'surname.max' => '* Прізвище не може бути довшим за 255 символів.',

            'name.required' => '* Обов`язкове поле.',
            'name.string' => '* Імʼя має бути рядком.',
            'name.max' => '* Імʼя не може бути довшим за 255 символів.',

            'email.required' => '* Обов`язкове поле.',
            'email.email' => '* Введіть коректну електронну адресу.',
            'email.unique' => '* Ця електронна адреса вже використовується.',

            'phone.required' => '* Обов`язкове поле.',
            'phone.string' => '* Телефон має бути рядком.',
            'phone.max' => '* Телефон не може бути довшим за 255 символів.',

            'address.required' => '* Обов`язкове поле.',
            'address.string' => '* Адреса має бути рядком.',
            'address.max' => '* Адреса не може бути довшою за 255 символів.',

            'role_id.required' => '* Обов`язкове поле.',
            'role_id.exists' => '* Вибрана роль не існує.',
        ];
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
        ], $messages);

        $user->update([
            'login' => $validated1['login'] ?? $user->login,
            'surname' => $validated1['surname'],
            'name' => $validated1['name'],
            'email' => $validated1['email'],
            'phone' => $validated1['phone'],
            'address' => $validated1['address'],
            'role_id' => $validated1['role_id'],
        ]);

        return redirect()->route('user.volunteer.view_account')->with('success', 'Дані користувача оновлено успішно !!!');
    }
}
