@extends('layouts.app')
@include('layouts.header_admin')

@section('content')
    <div class="main-content" style="font-family: 'Open Sans', sans-serif;">
        <div class="card">
            <div class="card-header" style="margin: 0">
                <h2>Створення користувача</h2>
            </div>
            <form class="card-body" action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="label" for="login">Логін</label>
                    <div class="input-group">
                        <input type="text" class="form-input" id="login" name="login" value="{{ old('login') }}" placeholder="Введіть логін" >
                    </div>
                    @error('login')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-groups">
                    <div class="form-groupp">
                        <label class="label" for="password">Пароль</label>
                        <div class="input-group">
                            <input type="password" class="form-input" id="password" name="password" placeholder="Введіть пароль" >
                            <span class="toggle-password">
                                <img src="{{ asset('images/icon/eye-close.svg') }}" alt="Send">
                            </span>
                        </div>
                        @error('password')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-groupp">
                        <label class="label" for="password_confirmation">Підтвердити пароль</label>
                        <div class="input-group">
                            <input type="password" class="form-input" id="password_confirmation" name="password_confirmation" placeholder="Введіть пароль" >
                            <span class="toggle-password-confirmation">
                                <img src="{{ asset('images/icon/eye-close.svg') }}" alt="Send">
                            </span>
                        </div>
                        @error('password_confirmation')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label class="label" for="email">Електронна пошта</label>
                    <div class="input-group">
                        <input type="email" class="form-input" id="email" name="email" value="{{ old('email') }}" placeholder="Введіть пошту" >
                    </div>
                    @error('email')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-groups">
                    <div class="form-groupp" >
                        <label class="label" for="surname">Прізвище</label>
                        <div class="input-group">
                            <input type="text" class="form-input" id="surname" name="surname" value="{{ old('surname') }}" placeholder="Введіть прізвище" >
                        </div>
                        @error('surname')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-groupp" >
                        <label class="label" for="name">Ім'я</label>
                        <div class="input-group">
                            <input type="text" class="form-input" id="name" name="name" value="{{ old('name') }}" placeholder="Введіть ім'я" >
                        </div>
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label class="label" for="phone">Телефон</label>
                    <div class="input-group">
                        <input type="tel" class="form-input" id="phone" name="phone" value="{{ old('phone') }}" placeholder="Введіть телефон" >
                    </div>
                    @error('phone')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="label" for="address">Адреса</label>
                    <div class="input-group">
                        <input type="text" class="form-input" id="address" name="address" value="{{ old('address') }}" placeholder="Введіть адресу">
                    </div>
                    @error('address')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group role-group">
                    <label class="label" for="role_id">Роль</label>
                    <div class="role-options">
                        <label class="role-option">
                            <input type="radio" name="role_id" value="2" required {{ old('role_id') == 2 ? 'checked' : '' }}>
                            Волонтер
                        </label>
                        <label class="role-option">
                            <input type="radio" name="role_id" value="1" required {{ old('role_id') == 1 ? 'checked' : '' }}>
                            Військовий
                        </label>
                    </div>
                    @error('role_id')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-buttons">
                    <button type="submit" class="register-button">Створити</button>
                    <div class="label-reg">
                        <p>Не хочете створювати?</p>
                        <a id="back-button">Назад</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

<script>
    document.getElementById('back-button').addEventListener('click', function() {
        window.location.href = "{{ route('admin.users.index') }}";
    });

    document.getElementById('toggle-password').addEventListener('click', function() {
        const passwordField = document.getElementById('password');
        const passwordFieldType = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', passwordFieldType);

        const icon = this.querySelector('i');
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
    });

    document.getElementById('toggle-password-confirmation').addEventListener('click', function() {
        const passwordConfirmationField = document.getElementById('password_confirmation');
        const passwordFieldType = passwordConfirmationField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordConfirmationField.setAttribute('type', passwordFieldType);

        const icon = this.querySelector('i');
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
    });
    document.addEventListener('DOMContentLoaded', function() {
        const phoneInputField = document.querySelector("#phone");
        if (phoneInputField) {
            const iti = window.intlTelInput(phoneInputField, {
                initialCountry: "ua",
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js",
                nationalMode: false,
            });

            phoneInputField.addEventListener('input', function() {
                let maxDigits = 12;
                let digits = phoneInputField.value.replace(/\D/g, '');
                if (digits.length > maxDigits) {
                    phoneInputField.value = phoneInputField.value.slice(0, maxDigits);
                }
            });
        }
    });
</script>
<style>
    body {
        overflow-x: hidden;
    }

    * {
        box-sizing: border-box;
    }

    .main-content {
        background: linear-gradient(180deg, #FDFDF6 40%, #A3B18A 40%);
        max-width: 100%;
        margin: 0 auto;
        display: flex;
        justify-content: center;
        padding: 32px;
    }

    .card {
        width: 100%;
        max-width: 450px;
        border: none !important;
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        background-color: transparent !important;
    }

    .card-header {
        text-align: center;
        color: var(--black-my);
        font-size: 2rem;
        font-weight: 700;
        background-color: transparent !important;
        border: none !important;
    }

    .card-body {
        display: flex;
        flex-direction: column;
        gap: 16px;
        background-color: var(--yellow-my);
        border-radius: 16px;
        padding: 1.2rem 2rem;
        margin: 0;
    }

    .label {
        font-size: 1rem;
        font-weight: 400;
        color: var(--black-my);
        margin: 0;
    }

    .form-groups {
        width: 100%;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        gap: 6px;
        margin: 0;
    }



    .form-group {
        display: flex;
        flex-direction: column;
        gap: 4px;
        margin: 0;
    }
    .form-groupp {
        width: 50%;
        display: flex;
        flex-direction: column;
        gap: 4px;
        margin: 0;
    }

    .input-group {
        display: flex;
        flex-direction: row;
        align-items: center;
        background-color: var(--main-white);
        border-radius: 16px;
        padding: 0 8px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    @media (max-width: 768px) {
        .form-groups {
            width: 100%;
            flex-direction: column;
            gap: 16px;
        }
        .form-groupp {
            width: 100%;
        }
        .input-group{
            justify-content: space-between;
        }
    }


    .form-input {
        padding: 0.5rem;
        font-size: 1rem;
        border: none;
        outline: none;
        background: transparent;
        color: var(--black-my);
        width: auto;
        min-width: 5ch;
        max-width: 80%;
    }

    .form-input::placeholder {
        color: var(--greey-my);
    }

    .form-input:hover::placeholder {
        color: var(--green-dark);
    }

    .toggle-password, .toggle-password-confirmation {
        background: transparent;
        border: none;
        padding: 0.5rem;
        cursor: pointer;
    }

    .role-group {
        color: var(--green-dark);
    }

    .role-options {
        display: flex;
        gap: 16px;
        flex-wrap: wrap;
    }

    .role-option {
        display: flex;
        align-items: center;
        font-size: 1rem;
        font-weight: 500;
        gap: 6px;
        cursor: pointer;
    }

    .role-option input[type="radio"] {
        width: 16px;
        height: 16px;
        accent-color: var(--green-light);
    }


    .form-buttons {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .register-button {
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

    .register-button:hover {
        background-color: var(--green-dark);
        transform: scale(1.05);
    }

    .label-reg {
        display: flex;
        justify-content: center;
        gap: 0.25rem;
        font-size: 0.875rem;
    }

    .label-reg p {
        margin: 0;
        color: var(--green-dark);
    }

    .label-reg a {
        color: var(--green-light);
        text-decoration: none;
    }

    .label-reg a:hover {
        text-decoration: underline;
    }
</style>
