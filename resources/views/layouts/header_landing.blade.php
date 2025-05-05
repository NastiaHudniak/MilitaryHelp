<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Landing Page')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <link href="{{ asset('css/icon.css') }}" rel="stylesheet">
    <link href="{{ asset('css/global.css') }}" rel="stylesheet">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            margin: 0;
            padding: 0;
            width: 100%;
        }
        .header-admin {
            font-family: 'Open Sans', sans-serif;
            width: 100%;
            background-color: var(--yellow-opasity);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 24px;
            backdrop-filter: blur(20px);
            position: sticky;
            top: 0;
            z-index: 1000;
            flex-wrap: wrap;
        }

        .header-left {
            display: flex;
            align-items: center;
        }

        .logo img {
            height: 40px;
            width: auto;
        }

        .header-center {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-grow: 1;
            margin: 12px 0;
        }

        .navbar-custom {
            display: flex;
            gap: 32px;
            flex-wrap: wrap;
            justify-content: center;
            font-size: 16px;
            font-weight: 600;
            line-height: 27px;
        }

        .navbar-custom .nav-link {
            color: var(--green-dark);
            position: relative;
            text-decoration: none;
            transition: color 0.3s ease-in-out;
        }

        .navbar-custom .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            background-color: var(--black-my);
            left: 0;
            bottom: -2px;
            transition: width 0.3s ease-in-out;
        }

        .navbar-custom .nav-link:hover::after {
            width: 100%;
        }

        .navbar-custom .nav-link:hover {
            color: var(--black-my);
        }

        .navbar-custom .nav-link.active {
            transform: scale(0.95);
            color: var(--orange-my);
        }

        .navbar-custom .nav-link.active::after {
            width: 100%;
            background-color: var(--orange-my);
        }

        .header-right {
            display: flex;
            align-items: center;
            margin-top: 12px;
        }

        .login-button {
            background-color: var(--orange-my);
            border-radius: 16px;
            color: var(--main-white);
            font-size: 16px;
            font-weight: 600;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            transition: background-color 0.5s ease, transform 0.3s ease;
        }

        .login-button:hover {
            background-color: var(--orange-dark);
            color: var(--main-white);
            transform: scale(1.05);
        }

        /* === Мобільна адаптація === */
        @media (max-width: 768px) {

            .header-admin {
                flex-direction: column;
            }
            .header-center {
                flex-direction: row;
            }

            .login-button {
                width: 100%;
            }
        }

    </style>
</head>
<body>

<!-- Admin Header -->
<header class="header-admin">
    <div class="header-left">
        <a class="logo" href="#logos">
            <img src="{{ asset('images/logo/logo_mini.svg') }}" alt="Logo">
        </a>
    </div>
    <div class="header-center">
        <nav class="navbar-custom">
            <a href="#help-section" class="nav-link active">Головна</a>
            <a href="#about-section" class="nav-link">Про нас</a>
            <a href="#volunteers-section" class="nav-link">Допомога</a>
        </nav>
    </div>

    <div class="header-right">
        <a class="login-button" href="{{ url('auth/login') }}">
            Увійти
        </a>
    </div>
</header>

<!-- Основний Контент -->
<div class="container" style="max-width: 1800px;">
    @yield('content')
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
