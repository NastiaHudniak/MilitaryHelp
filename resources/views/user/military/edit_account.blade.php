@extends('layouts.app')
@include('layouts.header_military_notsearch')
<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/icon.css') }}" rel="stylesheet">
    <link href="{{ asset('css/global.css') }}" rel="stylesheet">
</head>
@section('content')

    <div class="container" style="max-width: 500px; margin: 0 auto; padding: 50px 0px;">
        <div class="title-name">
            <h style=" color: var(--green-800); font-size: 40px; text-shadow: 0.5px 0 0 var(--green-800), 0 0.5px 0 var(--green-800), -0.5px 0 0 var(--green-800), 0 -0.5px 0 var(--green-800);" class="b">Редагування інформації </h>
            <span class="mr-3" style=" color: var(--green-800); font-size: 40px; "> Вітаємо, {{ $user->login }}!</span>
        </div>
        <div class="card" style="box-shadow: 0 6px 15px rgba(0, 0, 0, 0.8);">
            <div class="card-body" style="background-color: var(--yellow-200);">
                <form id="user-form" action="{{ route('user.military.update_account', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
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
                        <label for="login">Логін</label>
                        <input type="text" class="form-control" id="login" name="login" value="{{ old('login', $user->login) }}" required>
                        @error('login')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="surname">Прізвище</label>
                        <input type="text" class="form-control" id="surname" name="surname" value="{{ old('surname', $user->surname) }}" required>
                        @error('surname')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name">Імʼя</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Електронна пошта</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone">Телефон</label>
                        <input type="tel" class="form-control" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                        @error('phone')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="address">Адреса</label>
                        <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $user->address) }}">
                        @error('address')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="role_id">Роль</label>
                        <select class="form-control" id="role_id" name="role_id" required>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('role_id')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-warning" style="background-color: var(--yellow-500);">Зберегти зміни</button>
                        <button type="button" class="btn btn-outline mx-3" style="color: var(--green-500);border-color: var(--green-500);" id="back-button">
                            <i class="fas fa-arrow-left"></i> Назад</button>
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
                                    window.location.href = "{{ route('user.military.index') }}";
                                }
                            } else {
                                window.location.href = "{{ route('user.military.index') }}";
                            }
                        });
                    </script>
                </form>
            </div>
        </div>
    </div>

    @include('layouts.footer')
@endsection

