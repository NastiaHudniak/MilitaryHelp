<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Адмін Панель')</title>
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
            justify-content: space-between;
            align-items: center;
            padding: 8px;
            color: var(--yellow-200);
            font-family: 'Jura', sans-serif;
            position: sticky; /* Робимо хедер прикріпленим */
            top: 0;
            z-index: 1000;
        }
        .logo-and-home {
            display: flex;
            align-items: center;
            gap: 24px;
        }
        .navbar-custom {
            display: flex;
            gap: 40px;
            font-weight: 600;
            letter-spacing: 0.12em;
            font-size: 24px;
        }
        .navbar-custom .nav-link {
            color: var(--yellow-200);
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
            color: var(--yellow-200);
        }

        .navbar-custom .nav-link.active::after {
            width: 100%;
        }

        .account {
            display: flex;
            align-items: center;
        }
    </style>
</head>
<body>

<!-- Admin Header -->
<header class="header-admin">
    <div class="logo-and-home">
        <img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="mr-3" style="width: 70px; height: auto; border-radius: 50%;">
        <a href="{{ route('admin.home.index') }}" class="bi bi-house" style="color: var(--yellow-200); font-size: 2rem; "></a>
    </div>

    <nav class="navbar-custom">
        <a class="nav-link {{ request()->is('admin/users') ? 'active' : '' }}" href="{{ url('/admin/users') }}">
            Користувачі
        </a>
        <a class="nav-link {{ request()->is('admin/applications') ? 'active' : '' }}" href="{{ url('/admin/applications') }}">
            Заявки
        </a>
        <a class="nav-link {{ request()->is('admin/categories') ? 'active' : '' }}" href="{{ url('/admin/categories') }}">
            Категорії
        </a>
    </nav>

    <div class="logout-container" style="color: var(--yellow-400); font-size: 20px;">
                <form action="{{ route('logout') }}" method="POST" style="width: 37px; height: 37px; ">
                    @csrf
                    <a class="ic--outline-logout" onClick="confirmLogout()" style="color: var(--yellow-400); font-size: 37px;"></a>
                </form>
            </div>
</header>

<!-- Основний Контент -->
<div class="container " style="max-width: 1800px;">
    @yield('content')
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
function confirmLogout() {
        if (confirm("Ви дійсно бажаєте вийти з акаунта?")) {
            document.querySelector('form').submit();
        }
    }
</script>
</body>
</html>
