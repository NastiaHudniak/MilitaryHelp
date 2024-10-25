<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Лендінг')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Jura:wght@600&display=swap">
    <link href="{{ asset('css/icon.css') }}" rel="stylesheet">
    <link href="{{ asset('css/global.css') }}" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            width: 100%;
        }
        .header-admin {
            width: 100%;
            background-color: var(--green-800);
            display: flex;
            align-items: center;
            padding: 8px 24px; /* Додано padding */
            color: var(--green-200);
            font-family: 'Jura', sans-serif;
            position: sticky; /* Робимо хедер прикріпленим */
            top: 0;
            z-index: 1000;
        }


        .logo {
            margin-right: 24px; /* Відстань між лого та навігацією */
        }
        .navbar-custom {
            display: flex;
            justify-content: space-around; /* Розподіл елементів по всій ширині */
            flex-grow: 1; /* Дозволяє навігації займати доступний простір */
            font-weight: 600;
            letter-spacing: 0.12em;
            font-size: 24px;
        }
        .navbar-custom .nav-link {
            color: var(--green-200);
            position: relative;
            text-decoration: none;
            transition: color 0.3s ease-in-out;
        }

        .navbar-custom .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            background-color: var(--yellow-200);
            left: 0;
            bottom: -2px;
            transition: width 0.3s ease-in-out;
        }

        .navbar-custom .nav-link:hover::after {
            width: 100%;
        }

        .navbar-custom .nav-link:hover {
            color: var(--yellow-200);
        }

        .navbar-custom .nav-link:active {
            transform: scale(0.95);
        }

        .navbar-custom .nav-link.active {
            color: var(--green-200);
        }

        .navbar-custom .nav-link.active::after {
            width: 100%;
        }

        .login-button {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 133px;
            height: 52px;
            background-color: var(--yellow-500);
            border-radius: 10px;
            color: var(--green-800);
            text-align: center;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            line-height: 36px;
            transition: background-color 0.3s ease, color 0.3s ease; /* Анімація зміни кольору */
        }

        .login-button:hover {
            background-color: var(--green-500);
            color: var(--yellow-200);
            text-decoration: none; /* Без підкреслення при наведенні */
            transform: scale(1.1);
        }
    </style>
</head>
<body>

<!-- Admin Header -->
<header class="header-admin">
    <a class="logo" href="#logos">
        <img src="{{ asset('images/logo.jpg') }}"   alt="Logo" style="width: 70px; height: auto; border-radius: 50%;">
    </a>

    <nav class="navbar-custom">
        <a href="#help-section" class="nav-link">Допомога</a>
        <a href="#about-section" class="nav-link">Про нас</a>
        <a href="#volunteers-section" class="nav-link">Волонтери</a>
        <a class="login-button" href="{{ url('auth/login') }}">
            Увійти
        </a>
    </nav>
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
