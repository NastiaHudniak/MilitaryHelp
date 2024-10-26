@extends('layouts.app')

<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/icon.css') }}" rel="stylesheet">
    <link href="{{ asset('css/global.css') }}" rel="stylesheet">
</head>

@section('content')
    <div class="container-fluid" style="padding: 0;">
        <div class="row" style="height: 100vh; display: flex;">
            <div class="col-md-6 p-0">
                <div style="height: 100%; background-image: url('{{ asset('images/pattern-c.png') }}'); background-size: cover; background-position: center;">
                </div>
            </div>
            <div class="col-md-6 d-flex justify-content-center align-items-center">
                <div class="card" style="max-width: 400px; width: 100%; box-shadow: 0 6px 15px rgba(0, 0, 0, 0.5);">
                    <div class="card-header" style="background-color: var(--yellow-200); color: var(--green-800);">
                        <h2>Оновлення пароля</h2>
                    </div>
                    <div class="card-body" style="background-color: #fcfde1;">
                        <form action="{{ route('password.update') }}" method="POST">
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

                            <div class="form-group" style="color: var(--green-800);">
                                <label for="email">Електронна пошта</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus>
                            </div>

                            <div class="form-group" style="color: var(--green-800);">
                                <label for="password">Новий пароль</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password" required style="border-radius: 5px;">
                                    <span class="toggle-password" style="cursor: pointer;">
                                        <i class="fas fa-eye-slash"></i>
                                    </span>
                                </div>
                                @error('password')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group" style="color: var(--green-800);">
                                <label for="password_confirmation">Підтвердити новий пароль</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required style="border-radius: 5px;">
                                    <span class="toggle-password-confirmation" style="cursor: pointer;">
                                        <i class="fas fa-eye-slash"></i>
                                    </span>
                                </div>
                                @error('password_confirmation')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-login">Оновити пароль</button>

                            <div style="margin-top: 20px; text-align: center;">
                                <p>Згадали пароль? <a style="color: var(--green-500);" href="{{ route('login') }}">Увійти</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .btn-login {
            background-color: var(--green-500);
            width: 100%;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
            border-radius: 5px;
            color: var(--yellow-200);
        }

        .btn-login:hover {
            background-color: var(--green-800);
            color: var(--yellow-200);
        }

        .form-control:focus {
            border-color: var(--green-500);
            box-shadow: 0 0 5px var(--green-800);
            opacity: 0.5;
        }

        .form-control {
            background-color: var(--yellow-200);
        }

        .input-group {
            position: relative;
        }

        .input-group .toggle-password,
        .input-group .toggle-password-confirmation {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }

        .toggle-password i,
        .toggle-password-confirmation i {
            color: #dc3545;
        }

        .toggle-password i.fa-eye-slash,
        .toggle-password-confirmation i.fa-eye-slash {
            color: #555555;
        }
    </style>

    <script>
        document.querySelector('.toggle-password').addEventListener('click', function() {
            const passwordField = document.getElementById('password');
            const passwordFieldType = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', passwordFieldType);

            const icon = this.querySelector('i');
            icon.classList.toggle('fa-eye-slash');
            icon.classList.toggle('fa-eye');
        });

        document.querySelector('.toggle-password-confirmation').addEventListener('click', function() {
            const passwordConfirmationField = document.getElementById('password_confirmation');
            const passwordFieldType = passwordConfirmationField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordConfirmationField.setAttribute('type', passwordFieldType);

            const icon = this.querySelector('i');
            icon.classList.toggle('fa-eye-slash');
            icon.classList.toggle('fa-eye');
        });
    </script>
@endsection
