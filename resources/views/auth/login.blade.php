@extends('layouts.app')

<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
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
                    <div class="card-header" style="background-color: #FAFBC9; color: #2B4324;">
                        <h2>Вхід в акаунт</h2>
                    </div>
                    <div class="card-body" style="background-color: #FCFDE1;">
                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                               <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="form-group" style=" color: #2B4324;">
                                <label for="login">Логін</label>
                                <input type="login" class="form-control" id="login" name="login" required>
                                @error('login')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group" style=" color: #2B4324;">
                                <label for="password">Пароль</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password" required style="border-radius: 5px;">
                                    <span class="toggle-password">
                                        <i class="fas fa-eye-slash"></i>
                                    </span>
                                </div>
                                @error('password')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-login">Увійти</button>
                            <div class="divider">Або</div>
                            <div style="margin-top: 20px; text-align: center;">
                                <p>У Вас немає акаунта? <a href="{{ route('register') }}">Зареєструватися</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .divider {
            text-align: center;
            margin: 20px 0;
            position: relative;
        }

        .divider::before,
        .divider::after {
            content: '';
            display: inline-block;
            width: 38%;
            height: 1px;
            background-color: #ddd;
            vertical-align: middle;
            margin: 0 10px;
        }

        .btn-login {
            background-color: #2C73BB;
            width: 100%;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
            border-radius: 5px;
            color: white;
        }

        .btn-login:hover {
            background-color: #266198;
            color: white;
        }

        .form-control:focus {
            border-color: #2C73BB;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .form-control{
            background-color: #FEFEF2;
        }


        .input-group {
            position: relative;
        }

        .input-group .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }

        .toggle-password i {
            color: #dc3545;
        }

        .toggle-password i.fa-eye-slash {
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
    </script>
@endsection
