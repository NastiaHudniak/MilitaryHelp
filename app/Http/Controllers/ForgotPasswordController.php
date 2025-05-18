<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset', ['token' => $token, 'email' => $request->email]);
    }

    public function sendResetLinkEmail(Request $request)
    {
        $messages = [
            'email.required' => '* Обов’язкове поле.',
            'email.email' => '* Неправильний формат електронної пошти.',
        ];

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ], $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $response = Password::sendResetLink($request->only('email'));

        return $response == Password::RESET_LINK_SENT
            ? back()->with('success', 'Посилання для скидання пароля надіслано на вашу електронну адресу.')
            : back()->withErrors(['email' => 'Не вдалося надіслати посилання для скидання пароля. Спробуйте ще раз.']);
    }


    public function reset(Request $request)
    {
        $messages = [
            'email.required' => '* Обов’язкове поле.',
            'email.email' => '* Неправильний формат електронної пошти.',
            'password.required' => '* Обов’язкове поле.',
            'password.confirmed' => '* Паролі не збігаються.',
            'password.min' => '* Пароль має містити щонайменше 6 символів.',
            'token.required' => '* Токен відсутній або недійсний.',
        ];

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
            'token' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $response = Password::reset($request->only('email', 'password', 'password_confirmation', 'token'), function ($user, $password) {
            $user->password = Hash::make($password);
            $user->save();
        });

        return $response == Password::PASSWORD_RESET
            ? redirect()->route('login')->with([
                'status' => 'Пароль оновлено успішно.',
                'success' => 'Пароль оновлено успішно.'
            ])
            : back()->withErrors(['email' => trans($response)]);
    }
}
