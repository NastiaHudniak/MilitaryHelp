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
            position: sticky; /* Робимо хедер прикріпленим */
            top: 0;
            z-index: 1000;
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

        /*.search {*/
        /*    width: 100px;*/
        /*    position: relative;*/
        /*    letter-spacing: 0.08em;*/
        /*    line-height: 30px;*/
        /*    display: flex;*/
        /*    align-items: center;*/
        /*    flex-shrink: 0;*/
        /*    color: var(--green-500);*/
        /*}*/

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
    <nav class="logo-and-home">
        <img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="mr" style="width: 70px; height: auto; border-radius: 50%;">
        <a id="home-icon"  class="fluent--home-20-regular" style="color: var(--yellow-400);  font-size: 37px; " href="{{ route('user.volunteer.index') }}"></a>
    </nav>

    <nav class="navbar-search">
        <div class="search-title">
            <input type="text" class="search" style="background-color: var(--green-300); " id="search" placeholder="Пошук за назвою">
            {{--            <a class="search">Пошук</a>--}}
            <span class="mynaui--search"  style="color: var(--green-800); font-size: 32px; "></span>
        </div>
    </nav>

    <nav class="navbar-right">
        <a id="history-icon" class="solar--history-bold-duotone" style="color: var(--yellow-400); font-size: 37px; " href="{{ route('user.military.view_app') }}"></a>
        @if (!empty(Auth::user()->login))
            <span class="mr-3" style="font-size: 22px; color: var(--yellow-400);">
                {{ Auth::user()->login }}
               <i class="fas fa-circle-check" style="color: var(--green-500); margin-left: 5px;"></i>
            </span>
        @endif
        <a class="material-symbols-light--account-circle-outline"
           id="burger-icon"
           style="color: var(--yellow-400); font-size: 37px; cursor: pointer;">
            &#xE853;
        </a>


        <div id="burger-menu" class="burger-menu">
            <div class="details">
                <a href="{{ route('user.volunteer.view_account') }}" class="details-items" style="font-size:18px; color: var(--green-500); cursor: pointer;">
                    <span class="material-symbols-light--view-cozy-outline" style="color: var(--green-500);"></span>
                    <p>Переглянути</p>
                </a>
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
