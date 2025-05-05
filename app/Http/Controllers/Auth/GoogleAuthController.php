<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as GoogleUser;

class GoogleAuthController extends Controller
{
    public function redirectToGoogle(): RedirectResponse
    {
        return Socialite::driver('google')
            ->with([
                'prompt' => 'select_account consent',
            ])
            ->redirect();
    }

    public function handleGoogleCallback(): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            if (!$googleUser->getEmail()) {
                throw new \Exception('Google не повернув пошту.');
            }

            $email = $googleUser->getEmail();
            $firstName = $googleUser->user['given_name'] ?? '';
            $lastName = $googleUser->user['family_name'] ?? '';
            $googleId = $googleUser->getId();

            $user = User::where('email', $email)->first();

            if (!$user) {
                $user = User::create([
                    'login' => Str::replaceLast('@gmail.com', '', $email),
                    'name' => $lastName,
                    'surname' => $firstName,
                    'email' => $email,
                    'phone' => 'Немає телефону',
                    'address' => 'Немає адреси',
                    'password' => bcrypt(Str::random(16)),
                    'role_id' => 2, // Роль за замовчуванням: військовий
                    'google_id' => $googleId,
                ]);
            }

            Auth::login($user);

            return match ($user->role_id) {
                1 => redirect()->route('admin.home.index')->with('success', 'Авторизація успішна!'),
                2 => redirect()->route('user.military.index')->with('success', 'Авторизація успішна!'),
                3 => redirect()->route('user.volunteer.index')->with('success', 'Авторизація успішна!'),
                default => redirect('/')->withErrors('Невідома роль користувача.'),
            };
        } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
            return redirect()->route('login')->withErrors('Авторизацію було скасовано.');
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors('Сталася помилка авторизації: ' . $e->getMessage());
        }
    }
}
