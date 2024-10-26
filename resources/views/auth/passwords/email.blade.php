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
                        <h2>Скидання пароля</h2>
                    </div>
                    <div class="card-body" style="background-color: #fcfde1;">
                        <form action="{{ route('password.email') }}" method="POST">
                            @csrf
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
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>

                            <button type="submit" class="btn btn-email">Надіслати посилання для скидання пароля</button>

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
        .btn-email {
            background-color: var(--green-500);
            width: 100%;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
            border-radius: 5px;
            color: var(--yellow-200);
        }

        .btn-email:hover {
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

        a {
            text-decoration: none;
            font-size: 14px;
        }

        a:hover {
            text-decoration: none;
            color: #c53727;
        }

        p {
            text-decoration: none;
            font-size: 14px;
            color: #666;
        }
    </style>
@endsection
