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
        $validator = Validator::make($request->all(), [
            'login' => 'required|unique:users|max:255',
            'surname' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'role_id' => 'required|in:1,2', 
        ]);

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
        $validator = Validator::make($request->all(), [
            'login' => 'required|string|max:255', 
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $user = User::where('login', $request->login)->first();

        if (!$user) {
            return back()->withErrors([
                'login' => 'Користувача з такою електронною адресою не знайдено.',
            ])->withInput();
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'Невірний пароль.',
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
