<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\UserImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;




class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->get();
        $roles = Role::all();
        return view('admin.users.index', compact('users', 'roles'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
{
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

        'password.required' => '* Обов`язкове поле.',
        'password.string' => '* Пароль має бути рядком.',
        'password.min' => '* Пароль повинен містити щонайменше 8 символів.',
        'password.confirmed' => '* Паролі не збігаються.',

        'phone.required' => '* Обов`язкове поле.',
        'phone.string' => '* Телефон має бути рядком.',
        'phone.max' => '* Телефон не може бути довшим за 255 символів.',

        'address.required' => '* Обов`язкове поле.',
        'address.string' => '* Адреса має бути рядком.',
        'address.max' => '* Адреса не може бути довшою за 255 символів.',

        'role_id.required' => '* Обов`язкове поле.',
        'role_id.in' => '* Недопустиме значення ролі.',
    ];
    $validator = Validator::make($request->all(), [
        'login' => 'required|unique:users|max:255',
        'surname' => 'required|string|max:255',
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8|confirmed',
        'phone' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'role_id' => 'required|exists:roles,id',
    ], $messages);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Створюємо користувача і зберігаємо його у змінній $user
    $user = User::create([
        'login' => $request->input('login'),
        'surname' => $request->input('surname'),
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'password' => Hash::make($request->input('password')),
        'phone' => $request->input('phone'),
        'address' => $request->input('address'),
        'role_id' => $request->input('role_id'),
    ]);


        $imagePath = 'images/acc.jpg';

            UserImage::create([
                'user_id' => $user->id,
                'image_url' => $imagePath,
            ]);



    return redirect()->route('admin.users.index')->with('success', 'Користувач створений успішно !!!');
}



    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
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
            'role_id.exists' => '* Недопустиме значення ролі.',
        ];
        $isLoginChanged = $user->login !== $request->input('login');

        $validated = $request->validate([
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
            'login' => $validated['login'] ?? $user->login,
            'surname' => $validated['surname'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'role_id' => $validated['role_id'],
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Дані користувача оновлено успішно !!!');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('error', 'Користувача успішно видалено !!!');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $users = User::where('login', 'like', "%{$query}%")->with('role')->get();

        return response()->json(['users' => $users]);
    }

    public function filter(Request $request)
    {
        $query = $request->input('query');
        $role = $request->input('role');
        $users = User::with('role')
            ->when($query, function($queryBuilder) use ($query) {
                $queryBuilder->where('login', 'like', "%{$query}%");
            })
            ->when($role, function($queryBuilder) use ($role) {
                $queryBuilder->where('role_id', $role);
            })
            ->get();

        return response()->json(['users' => $users]);
    }


    public function exportPDF()
    {
        $users = User::with('role')->get();
        $totalUsers = $users->count();
        $pdf = Pdf::loadView('admin.users.pdf', compact('users', 'totalUsers'));

        return $pdf->download('users.pdf');
    }
}
