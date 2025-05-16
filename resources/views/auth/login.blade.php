@extends('layouts.app')

<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/icon.css') }}" rel="stylesheet">
    <link href="{{ asset('css/global.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/alerts.css') }}">
</head>

@section('content')
    <div class="auth-page">
        <div class="auth-logo">
            <a href="{{ route('user.landing.index') }}">
                <img src="{{ asset('images/logo/logo.svg') }}" alt="Логотип" class="logo">
            </a>
        </div>

        <div class="card">
            <div class="card-header" style="margin: 0">
                <h2>Вхід в акаунт</h2>
            </div>
            <form class="card-body" action="{{ route('login') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label class="label" for="login">Логін</label>
                        <div class="input-group">
                            <input type="login" class="form-input" id="login" name="login" placeholder="Введіть логін" >

                        </div>
                        @error('login')
                        <div class="text_danger_after_input">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group" >
                        <label class="label" for="password">Пароль</label>
                        <div class="input-group">
                            <input type="password" class="form-input" id="password" name="password" placeholder="Введіть пароль" >
                            <span class="toggle-password">
                                <img src="{{ asset('images/icon/eye-close.svg') }}" alt="Send">
                            </span>
                        </div>
                        @error('password')
                        <div class="text_danger_after_input">{{ $message }}</div>
                        @enderror
                    </div>

                    <a href="{{ route('password.request') }}" class="forgot">Забули пароль?</a>

                    <div class="form-buttons">
                        <button type="submit" class="login-button">Увійти</button>
                        <div class="login-divider">
                            <div class="divider-line"></div>
                            <span class="divider-text">Або</span>
                            <div class="divider-line"></div>
                        </div>

                        <a class="login-google-button" href="{{ route('google.redirect') }}">
                            <img alt="Google icon" src="{{ asset('images/icon/socialmedia-4.svg') }}">
                            <span>Увійти за допомогою Google</span>
                        </a>
                        <div class="label-log">
                            <p>У Вас немає акаунта? </p>
                            <a href="{{ route('register') }}">Зареєструватися</a>
                        </div>
                    </div>
                </form>
        </div>
    </div>

    <style>
        html, body {
            height: 100%;
            margin: 0;
            font-size: 16px;
        }

        .auth-page {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: linear-gradient(180deg, #FDFDF6 40%, #A3B18A 40%);
            padding: 20px;
            gap: 20px;

            position: relative;
        }

        .auth-logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            width: 150px;
            height: auto;
        }

        .card {
            width: 100%;
            max-width: 400px;
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            background-color: transparent;
        }

        .card-header {
            text-align: center;
            color: var(--black-my);
            font-size: 2rem;
            font-weight: 700;
            background-color: transparent;
            border: none;
        }

        .card-body {
            display: flex;
            flex-direction: column;
            gap: 24px;
            background-color: var(--yellow-my);
            border-radius: 16px;
            padding: 2rem;
            margin: 0;
        }

        .label {
            font-size: 1rem;
            font-weight: 400;
            color: var(--black-my);
            margin: 0;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin: 0 !important;
        }

        .input-group {
            display: flex;
            align-items: center;
            background-color: var(--main-white);
            border-radius: 16px;
            padding: 0 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .form-input {
            flex-grow: 1;
            padding: 0.5rem;
            font-size: 1rem;
            border: none;
            outline: none;
            background: transparent;
            color: var(--black-my);
        }

        .form-input::placeholder {
            color: var(--greey-my);
        }

        .form-input:hover::placeholder {
            color: var(--green-dark);
        }

        .toggle-password {
            background: transparent;
            border: none;
            padding: 0.5rem;
            cursor: pointer;
        }

        .forgot {
            font-size: 1rem;
            font-weight: 600;
            color: var(--main-green-dark);
            display: inline-block;
            margin-top: -10px;
        }
        .forgot:hover {

            color: var(--green-dark);

        }

        .form-buttons {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .login-button,
        .login-google-button {
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 16px;
            transition: all 0.3s ease-in-out;
        }

        .login-button {
            background-color: var(--main-green-dark);
            color: var(--main-white);
            border: none;
            padding: 0.83rem;
        }

        .login-button:hover {
            background-color: var(--green-dark);
            transform: scale(1.05);
        }

        .login-google-button {
            background-color: var(--main-white);
            color: var(--main-green-dark);
            border: 2px solid var(--main-green-dark);
            gap: 0.75rem;
            padding: 0.60rem;
        }

        .login-google-button:hover {
            background-color: var(--green-light);
            transform: scale(1.05);
            text-decoration: none;
            color: var(--main-green-dark);
        }

        .login-divider {
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--greey-my);
            font-size: 0.875rem;
            gap: 0.5rem;
        }

        .divider-line {
            flex-grow: 1;
            border-top: 1px solid var(--greey-my);
        }

        .label-log {
            display: flex;
            justify-content: center;
            gap: 0.25rem;
            font-size: 0.875rem;
        }

        .label-log p {
            margin: 0;
            color: var(--green-dark);
        }

        .label-log a {
            color: var(--green-light);
            text-decoration: none;
        }

        .label-log a:hover {
            text-decoration: underline;
        }

        @media (min-width: 768px) {
            .auth-page {
                flex-direction: row;
                justify-content: center;
                align-items: center;
                gap: 80px;
            }

            .auth-logo {
                position: absolute;
                top: 20px;
                left: 20px;
                margin-bottom: 0;
                text-align: left;
            }

            .logo {
                width: 140px;
            }
        }
    </style>


    <script>
        document.querySelector('.toggle-password').addEventListener('click', function () {
            const passwordField = document.getElementById('password');
            const isPasswordHidden = passwordField.getAttribute('type') === 'password';
            passwordField.setAttribute('type', isPasswordHidden ? 'text' : 'password');

            const img = this.querySelector('img');
            img.src = isPasswordHidden
                ? "{{ asset('images/icon/eye-open.svg') }}"
                : "{{ asset('images/icon/eye-close.svg') }}";
        });
    </script>

@endsection
