<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ForgotPassword;
use App\Models\User;
use App\Models\UserImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
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
            'role_id' => 'required|in:1,2',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $role_id = $request->input('role_id') == 1 ? 2 : 3;

        $user = User::create([
            'login' => $request->login,
            'password' => Hash::make($request->input('password')),
            'surname' => $request->surname,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'role_id' => $role_id,
        ]);

        $imagePath = 'images/acc.jpg';

            UserImage::create([
                'user_id' => $user->id,
                'image_url' => $imagePath,
            ]);
        Auth::login($user);
        return redirect()->route('login')->with('success', 'Реєстрація успішна!');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $messages = [
            'login.required' => '* Обов`язкове поле.',
            'login.string' => '* Логін має бути рядком.',
            'login.max' => '* Логін не може бути довшим за 255 символів.',

            'password.required' => '* Обов`язкове поле.',
            'password.string' => '* Пароль має бути рядком.',
            'password.min' => '* Пароль повинен містити не менше 8 символів.',
        ];

        $validator = Validator::make($request->all(), [
            'login' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $user = User::where('login', $request->login)->first();

        if (!$user) {
            return back()->withErrors([
                'login' => '*Користувача з такою електронною адресою не знайдено.',
            ])->withInput();
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => '*Невірний пароль.',
            ])->withInput();
        }

        Auth::login($user);
        $request->session()->regenerate();

        if ($user->role_id == 1) {
            return redirect()->route('admin.home.index')->with('success', 'Авторизація успішна!');
        }
        elseif ($user->role_id == 2) {
            return redirect()->route('user.military.index')->with('success', 'Авторизація успішна!');
        }
        elseif ($user->role_id == 3) {
            return redirect()->route('user.volunteer.index')->with('success', 'Авторизація успішна!');
        }

        return redirect()->route('/')->withErrors('Невідома роль користувача.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Ви успішно вийшли з акаунту!');
    }
}
