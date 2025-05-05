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
            font-family: 'Open Sans', sans-serif;
            margin: 0;
            padding: 0;
            width: 100%;
        }
        .header-military {
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
            gap: 18px;
        }

        .logo img {
            height: 50px;
            width: auto;
        }

        .logo img {
            background-color: var(--orange-my);
            border-radius: 50px;
            padding: 4px;
        }

        .header-center {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-grow: 1;
            margin: 0;
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
            gap: 8px;
        }

        .text-log{
            color: var(--black-my);
            font-size: 18px;
            font-weight: 600;
            line-height: 27px;
            word-wrap: break-word
        }







        .navbar-search {
            display: flex;
            justify-content: space-around;
            align-items: center;
            font-weight: 600;
            letter-spacing: 0.12em;
            font-size: 24px;
            gap: 20px;
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
            padding: 5px 10px;
            box-sizing: border-box;
            text-align: left;
            font-size: var(--medium-24-8-size);
            color: var(--green-500);
            gap: 30px;
        }

        .search {
            position: relative;
            letter-spacing: 0.08em;
            line-height: 30px;
            display: flex;
            align-items: center;
            flex-shrink: 0;
            color: var(--green-500);
            border: none; /* Відключаємо рамку */
            outline: none;

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
        }



        /* Бургер-меню */
        .burger-menu {
            position: fixed;
            right: -300px; /* Початкова позиція (за межами екрану) */
            top: 90px; /* Піднімаємо під хедером (висота хедера 70px) */
            width: 300px;
            height: 88%;
            background-color: var(--green-800);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.8);
            color: white;
            transition: right 0.3s ease;
            z-index: 1000; /* Щоб воно перекривало інші елементи */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* Стиль для відкритого меню */
        .burger-menu.open {
            right: 0;
        }

        .details-item  {
            width: 100%; /* Розмір блоку */
            margin: 10px;
            display: flex;
            gap: 20px; /* Проміжок між іконкою та текстом */
        }

        .details-items {
            width: 100%; /* Розмір блоку */
            display: flex;
            flex-direction: row;
            text-align: center;
            padding-left: 50px;
            align-items: center;
            gap: 20px; /* Проміжок між іконкою та текстом */
         }

        .details{
             display: flex;
             justify-content: space-between;
             flex-wrap: wrap;
         }

        .divider {
            width: 80%;
            text-align: center;
            margin: auto;
            position: relative;
            border-bottom: 1px solid var(--green-500); /* Створює одну суцільну лінію */
        }

        /* Зміни в CSS для елемента "Вийти з акаунту" */
        .logout-container {
            width: 100%; /* Розмір блоку */
            margin: 10px;
            display: flex;
            gap: 20px; /* Проміжок між іконкою та текстом */
            text-align: center;
            align-items: center;

        }









    </style>
</head>
<body>

<!-- Admin Header -->
<header class="header-military">
    <div class="header-left">
        <a class="logo" href="#logos">
            <img src="{{ asset('images/logo/logo_mini.svg') }}" alt="Logo">
        </a>
        <a id="add-icon" href="{{ route('user.military.create') }}">
            <img src="{{ asset('images/icon/znak.svg') }}" alt="Додати" >
        </a>

        <a id="history-icon" href="{{ route('user.military.view_app') }}">
            <img src="{{ asset('images/icon/history.svg') }}" alt="Історія" >
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
        @if (!empty(Auth::user()->login))
            <span class="text-log">
                {{ Auth::user()->login }}
            </span>
        @endif
            <a id="burger-icon" style="cursor: pointer;">
                <img src="{{ asset('images/icon/user-fill.svg') }}">
            </a>
    </div>


    <!--   <nav class="navbar-search">
        <div class="search-title">
                <input type="text" class="search" style="background-color: var(--green-300); " id="search" placeholder="Пошук за назвою">
         <span class="mynaui--search"  style="color: var(--green-800); font-size: 32px; "></span>
        </div>
    </nav>    -->
    <nav class="navbar-right">
        <div id="burger-menu" class="burger-menu">
            <div class="details">
                <a class="details-item" id="account-info-toggle" style="font-size:20px; color: var(--yellow-400); cursor: pointer;">
                    <span class="si--info-line" style="color: var(--yellow-400); font-size:40px"></span>
                    <p>Інформація про акаунт</p>
                </a>
                <!-- Додаткові елементи, які будуть показані при натисканні -->
                <div id="account-info-extra" style="display: none;">
                    <a href="{{ route('user.military.view_account') }}" class="details-items" style="font-size:18px; color: var(--green-500); cursor: pointer;">
                        <span class="material-symbols-light--view-cozy-outline" style="color: var(--green-500);"></span>
                        <p>Переглянути</p>
                    </a>
                    <a href="{{ route('user.military.edit_account', Auth::user() ) }}"  class="details-items" style="font-size:18px; color: var(--green-500); cursor: pointer;">
                        <span class="cuida--edit-outline" style="color: var(--green-500);"></span>
                        <p>Редагувати</p>
                    </a>
                </div>
                <a class="details-item" href="{{ route('user.military.create') }}" style="font-size:20px; color: var(--yellow-400);">
                    <span class="fluent-mdl2--add-to" style="color: var(--yellow-400); font-size:40px"></span>
                    <p>Додати заявку</p>
                </a>
                <a class="details-item"href="{{ route('user.military.view_app') }}" style="font-size:20px;color: var(--yellow-400);">
                    <span class="solar--history-bold-duotone" style="color: var(--yellow-400); font-size:42px"></span>
                    <p>Переглянути усі заявки</p>
                </a>
                <a class="details-item"href="{{ route('user.military.vol.view_volunteer') }}" style="font-size:20px;color: var(--yellow-400);">
                    <span class="solar--history-bold-duotone" style="color: var(--yellow-400); font-size:60px"></span>
                    <p>Переглянути список волонтерів</p>
                </a>
                <div class="divider"></div>
            </div>
            <div class="logout-container" style="color: var(--yellow-400); font-size: 20px;">
                <form action="{{ route('logout') }}" method="POST" style="width: 37px; height: 37px; ">
                    @csrf
                    <a class="ic--outline-logout" onClick="confirmLogout()" style="color: var(--yellow-400); font-size: 37px;"></a>
                </form>
                <p>Вийти з акаунту</p>
            </div>
        </div>
    </nav>
</header>

<!-- Основний Контент -->
<div class="container" style="max-width: 1800px;">
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

    document.addEventListener('DOMContentLoaded', function() {
        // Отримуємо іконку і меню
        const burgerIcon = document.getElementById('burger-icon');
        const burgerMenu = document.getElementById('burger-menu');
        const menuOverlay = document.createElement('div');
        menuOverlay.id = 'menu-overlay';
        document.body.appendChild(menuOverlay);

        // Обробник події для відкриття бургер-меню
        burgerIcon.addEventListener('click', function() {
            burgerMenu.classList.toggle('open');
            menuOverlay.classList.toggle('show'); // Показуємо фон
        });

        // Обробник події для закриття бургер-меню при кліку на фон
        menuOverlay.addEventListener('click', function() {
            burgerMenu.classList.remove('open');
            menuOverlay.classList.remove('show'); // Приховуємо фон
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const accountInfoToggle = document.getElementById('account-info-toggle');
        const accountInfoExtra = document.getElementById('account-info-extra');

        // Додаємо обробник події на "Інформація про акаунт"
        accountInfoToggle.addEventListener('click', function() {
            // Перемикаємо видимість додаткових полів
            accountInfoExtra.style.display = accountInfoExtra.style.display === 'none' ? 'block' : 'none';
        });
    });


    document.getElementById('home-icon').addEventListener('mouseover', function() {
        this.classList.remove('fluent--home-20-regular');
        this.classList.add('fluent--home-20-filled');
    });

    document.getElementById('home-icon').addEventListener('mouseout', function() {
        this.classList.remove('fluent--home-20-filled');
        this.classList.add('fluent--home-20-regular');
    });

    document.getElementById('filter-icon').addEventListener('mouseover', function() {
        this.classList.remove('streamline--filter-2');
        this.classList.add('streamline--filter-2-solid');
    });

    document.getElementById('filter-icon').addEventListener('mouseout', function() {
        this.classList.remove('streamline--filter-2-solid');
        this.classList.add('streamline--filter-2');
    });

    document.getElementById('add-icon').addEventListener('mouseover', function() {
        this.classList.remove('gridicons--add-outline');
        this.classList.add('gridicons--add');
    });

    document.getElementById('add-icon').addEventListener('mouseout', function() {
        this.classList.remove('gridicons--add');
        this.classList.add('gridicons--add-outline');
    });

    document.getElementById('history-icon').addEventListener('mouseover', function() {
        this.classList.remove('solar--history-bold-duotone');
        this.classList.add('uim--history');
    });

    document.getElementById('history-icon').addEventListener('mouseout', function() {
        this.classList.remove('uim--history');
        this.classList.add('solar--history-bold-duotone');

    });



</script>
</body>
</html>
