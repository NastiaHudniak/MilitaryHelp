@extends('layouts.app')

<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/icon.css') }}" rel="stylesheet">
    <link href="{{ asset('css/global.css') }}" rel="stylesheet">
    <link href="{{ asset('css/alerts.css') }}" rel="stylesheet">

    <link href="{{ asset('css/loader.css') }}" rel="stylesheet">
</head>

@section('content')
    <div class="loader-overlay" id="loader" style="display: none;">
        <div class="loader"></div>
    </div>
    <div class="email-page">
        <div class="email-logo">
            <a  href="{{ route('user.landing.index') }}">
                <img src="{{ asset('images/logo/logo.svg') }}"  alt="Логотип" class="logo">
            </a>
        </div>

        <div class="card">
            <div class="card-header">
                <h2>Скидання пароля</h2>
            </div>
            <form class="card-body" action="{{ route('password.email') }}" method="POST">
                @csrf
                @if (session('status'))
                    <div class="alert-success-custom">{{ session('status') }}</div>
                @endif

                <div class="form-group">
                    <label class="label" for="email">Електронна пошта</label>
                    <div class="input-group">
                        <input type="email" class="form-input" id="email" name="email" placeholder="Введіть електронну пошту" >
                    </div>
                </div>

                <div class="form-buttons">
                    <button type="submit" class="email-button">Надіслати</button>
                    <div class="label-email">
                        <p>Згадали пароль? </p>
                        <a href="{{ route('login') }}">Увійти</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.querySelector('form').addEventListener('submit', function () {
            document.getElementById('loader').style.display = 'flex';
        });
    </script>

    <style>
        body, html {
            height: 100%;
            margin: 0;
        }

        .email-page {
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

        .email-logo {
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

        .form-buttons {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .email-button {
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

        .email-button:hover {
            background-color: var(--green-dark);
            transform: scale(1.05);
        }

        .label-email{
            display: flex;
            justify-content: center;
            gap: 0.25rem;
            font-size: 0.875rem;
        }

        .label-email p{
            margin: 0;
            color: var(--green-dark);
        }
        .label-email a{
            color: var(--green-light);
            text-decoration: none;
        }
        .label-email a:hover {
            text-decoration: underline;
        }


        @media (min-width: 768px) {
            .email-page {
                flex-direction: row;
                justify-content: center;
                align-items: center;
                gap: 80px;
            }

            .email-logo {
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
@endsection
