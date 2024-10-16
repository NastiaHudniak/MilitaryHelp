@extends('layouts.app')

<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
</head>

@section('content')
    <div class="container-fluid" style="padding: 0;">
        <div class="row" style="height: 100vh; display: flex;">
            <div class="col-md-6 d-flex justify-content-center align-items-center"   style="padding-bottom: 60px; padding-top: 60px;">
                <div class="card" style=" max-width: 400px; width: 100%; box-shadow: 0 6px 15px rgba(0, 0, 0, 0.5);">
                    <div class="card-header" style="background-color: #FAFBC9; color: #2B4324;">
                        <h2>Реєстрація</h2>
                    </div>
                    <div class="card-body" style="background-color: #FCFDE1;">
                        <form action="{{ route('register') }}" method="POST">
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
                                <input type="text" class="form-control" id="login" name="login" value="{{ old('login') }}" required>
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
                            <div class="form-group" style=" color: #2B4324;">
                                <label for="password_confirmation">Підтвердити пароль</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required style="border-radius: 5px;">
                                    <span class="toggle-password-confirmation">
                                <i class="fas fa-eye-slash"></i>
                            </span>
                                </div>
                                @error('password_confirmation')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group" style=" color: #2B4324;">
                                <label for="email">Електронна пошта</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group" style=" color: #2B4324;">
                                <label for="surname">Прізвище</label>
                                <input type="text" class="form-control" id="surname" name="surname" value="{{ old('surname') }}" required>
                                @error('surname')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group" style=" color: #2B4324;">
                                <label for="name">Ім'я</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group" style=" color: #2B4324;">
                                <label for="phone">Телефон</label>
                                <div>
                                    <input type="tel" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" style="width: 338px;">
                                    @error('phone')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group" style=" color: #2B4324;">
                                <label for="address">Адреса</label>
                                <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}">
                                @error('address')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group" style=" color: #2B4324;">
                                <label for="role_id">Роль</label>
                                <select class="form-control" id="role_id" name="role_id" required>
                                    <option value="1">Військовий</option>
                                    <option value="2">Волонтер</option>
                                </select>
                                @error('role_id')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-login">Зареєструватися</button>
                            <div style="margin-top: 20px; text-align: center;">
                                <p>Вже маєте акаунт? <a href="{{ route('login') }}">Увійти</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6 p-0">
                <div style="height: 100%; background-image: url('{{ asset('images/pattern-b.png') }}'); background-size: cover; background-position: center;">
                </div>
            </div>
        </div>
    </div>

    <style>

        .form-group {
            margin-bottom: 10px;
        }

        .form-control {
            padding: 8px;
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

        .card-body {
            padding: 15px;
        }

        .card-header {
            padding: 10px 15px;
        }

        .form-group label {
            font-weight: 500;
            color: #666;
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

        document.addEventListener('DOMContentLoaded', function() {
            const phoneInputField = document.querySelector("#phone");
            if (phoneInputField) {
                const iti = window.intlTelInput(phoneInputField, {
                    initialCountry: "ua",
                    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js",
                    nationalMode: false,
                    formatOnDisplay: true,
                    autoHideDialCode: false,
                });

                phoneInputField.addEventListener('input', function(e) {
                    let digits = phoneInputField.value.replace(/\D/g, '');

                    let countryData = iti.getSelectedCountryData();
                    let countryCode = countryData.dialCode;

                    if (countryCode === '380' && digits.length > 3) {
                        let formatted = digits.slice(0, 3);
                        let rest = digits.slice(3);
                        let match = rest.match(/(\d{0,2})(\d{0,3})(\d{0,2})(\d{0,2})/);

                        phoneInputField.value = '+' + formatted + ' ' + (match[1] ? match[1] : '') + (match[2] ? ' ' + match[2] : '') + (match[3] ? ' ' + match[3] : '') + (match[4] ? ' ' + match[4] : '');
                    }
                });

                phoneInputField.addEventListener('input', function() {
                    let maxDigits = 12;
                    let digits = phoneInputField.value.replace(/\D/g, '');
                    let countryData = iti.getSelectedCountryData();
                    let countryCodeLength = countryData.dialCode.length;

                    if (digits.length > (maxDigits + countryCodeLength)) {
                        phoneInputField.value = phoneInputField.value.slice(0, maxDigits + countryCodeLength + 1);
                    }
                });
            }
        });
    </script>

@endsection
