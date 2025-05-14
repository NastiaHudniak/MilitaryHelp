@extends('layouts.app')

<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/icon.css') }}" rel="stylesheet">
    <link href="{{ asset('css/global.css') }}" rel="stylesheet">
</head>

@section('content')
    <div class="reset-page">
        <a  href="{{ route('user.landing.index') }}">
            <img src="{{ asset('images/logo/logo.svg') }}"  alt="Логотип" class="logo">
        </a>

        <div class="card">
            <div class="card-header">
                <h2>Відновлення паролю</h2>
            </div>
            <form class="card-body" action="{{ route('password.update') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-group">
                    <label class="label" for="email">Електронна пошта</label>
                    <div class="input-group">
                        <input type="email" class="form-input" id="email" name="email" value="{{ old('email') }}" required autofocus>
                    </div>
                </div>

                <div class="form-group" >
                    <label class="label" for="password">Новий пароль</label>
                    <div class="input-group">
                        <input type="password" class="form-input" id="password" name="password" placeholder="Введіть пароль" required>
                        <span class="toggle-password">
                                <img src="{{ asset('images/icon/eye-close.svg') }}" alt="Send">
                            </span>
                    </div>
                    @error('password')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="label" for="password_confirmation">Підтвердити новий пароль</label>
                    <div class="input-group">
                        <input type="password" class="form-input" id="password_confirmation" name="password_confirmation" placeholder="Введіть пароль"  required >
                        <span class="toggle-password-confirmation">
                                <img src="{{ asset('images/icon/eye-close.svg') }}" alt="Send">
                            </span>
                    </div>
                    @error('password_confirmation')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-buttons">
                    <button type="submit" class="reset-button">Оновити пароль</button>
                    <div class="label-reset">
                        <p>Згадали пароль? </p>
                        <a href="{{ route('login') }}">Увійти</a>
                    </div>
                </div>





            </form>
        </div>
    </div>

    <style>
        body, html {
            height: 100%;
            margin: 0;
        }

        .reset-page {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            min-height: 100vh;
            background: linear-gradient(180deg, #FDFDF6 40%, #A3B18A 40%);
            padding: 20px;
            gap: 20px;
        }

        @media (min-width: 768px) {
            .reset-page {
                flex-direction: row;
                justify-content: center;
                gap: 80px;
            }
        }

        @media (min-width: 1024px) {
            .reset-page {
                display: flex;
                justify-content: center;
            }
        }

        .logo {
            width: 150px;
            height: auto;
            margin-bottom: 20px;
        }

        @media (min-width: 768px) {
            .logo {
                position: absolute;
                top: 40px;
                left: 40px;
                margin: 0;
            }
        }


        .card {
            width: 100%;
            max-width: 400px;
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            background-color: transparent;
            margin-bottom: 80px;
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
            margin: 0;
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

        .form-buttons {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .reset-button {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0.75rem;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 16px;
            transition: all 0.3s ease-in-out;
            background-color: var(--main-green-dark);
            color: var(--main-white);
            border: none;
        }


        .reset-button:hover {
            background-color: var(--green-dark);
            transform: scale(1.05);
        }


        .label-reset{
            display: flex;
            justify-content: center;
            gap: 0.25rem;
            font-size: 0.875rem;
        }

        .label-reset p{
            margin: 0;
            color: var(--green-dark);
        }
        .label-reset a{
            color: var(--green-light);
            text-decoration: none;
        }
        .label-reset a:hover {
            text-decoration: underline;
        }



    </style>
    <script>
        document.querySelector('.toggle-password').addEventListener('click', function () {
            const passwordField = document.getElementById('password');
            const passwordFieldType = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', passwordFieldType);

            const img = this.querySelector('img');
            if (passwordFieldType === 'text') {
                img.src = "{{ asset('images/icon/eye-open.svg') }}";
            } else {
                img.src = "{{ asset('images/icon/eye-close.svg') }}";
            }
        });

        document.querySelector('.toggle-password-confirmation').addEventListener('click', function () {
            const passwordConfirmationField = document.getElementById('password_confirmation');
            const passwordFieldType = passwordConfirmationField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordConfirmationField.setAttribute('type', passwordFieldType);

            const img = this.querySelector('img');
            if (passwordFieldType === 'text') {
                img.src = "{{ asset('images/icon/eye-open.svg') }}";
            } else {
                img.src = "{{ asset('images/icon/eye-close.svg') }}";
            }
        });
    </script>

@endsection
