@extends('layouts.app')
@include('layouts.header_volunteer')

@section('content')
    <div class="main-content" style="font-family: 'Open Sans', sans-serif;">
        <div class="main-info">
            @include('components.sidebar_account', ['user' => $user])
            <div class="card">
                <div class="card-header" style="margin: 0">
                    <h2>Редагування інформації</h2>
                    {{--                    <a class="card-header-name">Вітаємо, {{ $user->login }}!</a>--}}
                </div>
                <form id="user-form" class="card-body" action="{{ route('user.volunteer.update_account', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-groups">
                        <div class="form-groupp">
                            <label class="label" for="login">Логін</label>
                            <div class="input-group">
                                <input type="text" class="form-input" id="login" name="login" value="{{ old('login', $user->login) }}" placeholder="Введіть логін" >
                            </div>
                            @error('login')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-groupp">
                            <label class="label" for="surname">Прізвище</label>
                            <div class="input-group">
                                <input type="text" class="form-input" id="surname" name="surname" value="{{ old('surname', $user->surname) }}" placeholder="Введіть прізвище" >
                            </div>
                            @error('surname')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-groupp" >
                            <label class="label" for="name">Ім'я</label>
                            <div class="input-group">
                                <input type="text" class="form-input" id="name" name="name" value="{{ old('name', $user->name) }}" placeholder="Введіть ім'я" >
                            </div>
                            @error('name')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                    <div class="form-groups">
                        <div class="form-groupp">
                            <label class="label" for="email">Електронна пошта</label>
                            <div class="input-group">
                                <input type="email" class="form-input" id="email" name="email" value="{{ old('email', $user->email) }}" placeholder="Введіть пошту" >
                            </div>
                            @error('email')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-groupp">
                            <label class="label" for="phone">Телефон</label>
                            <div class="input-group">
                                <input type="tel" class="form-input" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Введіть телефон" >
                            </div>
                            @error('phone')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-groupp">
                            <label class="label" for="address">Адреса</label>
                            <div class="input-group">
                                <input type="text" class="form-input" id="address" name="address" value="{{ old('address', $user->address) }}" placeholder="Введіть адресу">
                            </div>
                            @error('address')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <input type="hidden" name="role_id" value="{{ $user->role_id }}">
                    {{--                    <div class="form-group role-group">--}}
                    {{--                        <label class="label" for="role_id">Роль</label>--}}
                    {{--                        <div class="role-options">--}}
                    {{--                            @foreach ($roles as $role)--}}
                    {{--                                @if(in_array($role->id, [2, 3]))--}}
                    {{--                                    <label class="role-option">--}}
                    {{--                                        <input type="radio" name="role_id" value="{{ $role->id }}" required--}}
                    {{--                                            {{ old('role_id', $user->role_id) == $role->id ? 'checked' : '' }}>--}}
                    {{--                                        {{ $role->name }}--}}
                    {{--                                    </label>--}}
                    {{--                                @endif--}}
                    {{--                            @endforeach--}}
                    {{--                        </div>--}}
                    {{--                        @error('role_id')--}}
                    {{--                        <div class="text-danger">{{ $message }}</div>--}}
                    {{--                        @enderror--}}
                    {{--                    </div>--}}

                    <div class="form-buttons">
                        <button type="submit" class="update-button">Зберегти зміни</button>
                        {{--                        <div class="label-ed">--}}
                        {{--                            <p>Не хочете змінювати дані?</p>--}}
                        {{--                            <a id="back-button" href="{{ route('user.military.view_account') }}">Повернутись</a>--}}
                        {{--                        </div>--}}
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
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

        let formChanged = false;
        const form = document.getElementById('user-form');
        const backButton = document.getElementById('back-button');


        form.addEventListener('change', function() {
            formChanged = true;
        });


        backButton.addEventListener('click', function() {
            if (formChanged) {
                const confirmLeave = confirm("Ви внесли зміни. Бажаєте зберегти їх перед тим, як вийти?");
                if (confirmLeave) {
                    form.submit();
                } else {
                    window.location.href = "{{ route('user.volunteer.view_account') }}";
                }
            } else {
                window.location.href = "{{ route('user.volunteer.view_account') }}";
            }
        });
    </script>
    @include('layouts.footer')
@endsection


<style>
    body {
        overflow-x: hidden;
    }

    * {
        box-sizing: border-box;
    }

    .main-content {
        background-color: var(--main-white);
        max-width: 100%;
        margin: 0 auto;
    }

    .main-info{
        display: flex;
        justify-content: left;
        flex-direction: row;
        align-items: start;
        padding: 64px 80px;
        gap: 80px;
    }



    @media (max-width: 768px) {

        .main-info{
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;
            padding: 24px;
            gap: 40px;
        }

        .sidebar-block-account{

            width: 100%;
        }

    }

    .card {
        width: 100%;
        max-width: 1000px;
        border: none !important;
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        background-color: transparent;
        padding: 0;
    }


    .card-header {
        margin: 0;
        color: var(--orange-my) !important;
        font-size: 44px;
        font-weight: 600;
        background-color: transparent !important;
        border: none !important;
        padding: 0 !important;
    }

    .card-header-name{
        text-align: center;
        color: var(--green-dark);
        font-size: 1rem;
        font-weight: 700;
        background-color: transparent !important;
        border: none !important;
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

    @media (max-width: 768px) {


        .card-header h2{
            font-size: 1.6rem;
        }
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
    .form-groups {
        width: 100%;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        gap: 12px;
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
        flex-grow: 1;
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

    .update-button {
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 1rem;
        font-weight: 600;
        border-radius: 16px;
        transition: all 0.3s ease-in-out;
        background-color: var(--main-green-dark);
        color: var(--main-white);
        border: none;
        padding: 0.83rem;
    }

    .update-button:hover {
        background-color: var(--green-dark);
        transform: scale(1.05);
    }




    .label-ed {
        display: flex;
        justify-content: center;
        gap: 0.25rem;
        font-size: 0.875rem;
    }

    .label-ed p {
        margin: 0;
        color: var(--green-dark);
    }

    .label-ed a {
        color: var(--green-light);
        text-decoration: none;
    }
    .label-ed a:visited,
    .label-ed a:hover,
    .label-ed a:focus,
    .label-ed a:active {
        color: var(--green-light);
        text-decoration: none;
    }

</style>
