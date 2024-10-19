<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Користувач')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Jura:wght@600&display=swap">
    <link href="{{ asset('css/icon.css') }}" rel="stylesheet">
    <link href="{{ asset('css/global.css') }}" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            width: 100%;
        }
        .header-military {
            background-color: var(--green-800);
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            font-family: 'Jura', sans-serif;
        }
        .logo-and-home {
            display: flex;
            align-items: center;
            gap: 24px;
            margin: 10px 20px;
        }
        .navbar-search {
            display: flex;
            justify-content: space-around;
            align-items: center;
            font-weight: 600;
            letter-spacing: 0.12em;
            font-size: 24px;
            gap: 30px;
            margin: 10px 20px;
        }

        .search-title {
            width: 100%;
            position: relative;
            border-radius: 40px;
            background-color: var(--green-300);
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            padding: 5px 20px;
            box-sizing: border-box;
            text-align: left;
            font-size: var(--bold-28-8-size);
            color: var(--green-500);
            gap: 150px;
        }

        .search {
            width: 100px;
            position: relative;
            letter-spacing: 0.08em;
            line-height: 30px;
            display: flex;
            align-items: center;
            flex-shrink: 0;
            color: var(--green-500);
        }

        .navbar-right {
            display: flex;
            align-items: center; /* Вирівнювання по вертикалі по центру */
            justify-content: space-between;
            gap: 20px; /* Відстань між іконками */
            margin: 10px 20px;
        }

        .navbar-right span {
            display: flex;
            align-items: center; /* Вирівнювання тексту або іконок по центру вертикально */
            justify-content: center;
            flex: 1; /* Авто-розтягування елементів по ширині */
        }



    </style>
</head>
<body>

<!-- Admin Header -->
<header class="header-military">
    <nav class="logo-and-home">
        <img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="mr" style="width: 70px; height: auto; border-radius: 50%;">
        <span class="fluent--home-20-regular" style="color: var(--yellow-400); font-size: 37px; "></span>
    </nav>

    <nav class="navbar-search">
        <div class="search-title">
            <a class="search">Пошук</a>
            <span class="mynaui--search"  style="color: var(--green-800); font-size: 37px; "></span>
        </div>

        <span class="oui--filter" style="color: var(--yellow-400); font-size: 37px; " ></span>
    </nav>

    <nav class="navbar-right">
        <a class="fluent-mdl2--add-to" style="color: var(--yellow-400); font-size: 37px;" href="{{ route('user.military.create') }}"></a>
        <span class="solar--history-bold-duotone" style="color: var(--yellow-400); font-size: 37px; "></span>
        @if (!empty(Auth::user()->login))
            <span class="mr-3" style="font-size: 22px; color: var(--yellow-400);">
                {{ Auth::user()->login }}
               <i class="fas fa-circle-check" style="color: var(--green-500); margin-left: 5px;"></i>
            </span>
        @endif
        <span class="material-symbols-light--account-circle" style="color: var(--yellow-400); font-size: 37px; "></span>
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
