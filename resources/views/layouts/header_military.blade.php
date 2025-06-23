<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Jura:wght@600&display=swap">
    <link href="{{ asset('css/icon.css') }}" rel="stylesheet">
    <link href="{{ asset('css/global.css') }}" rel="stylesheet">
</head>
<body>

<!-- Admin Header -->
<header class="header-military
        {{ in_array(Route::currentRouteName(), ['user.military.index']) ? 'header-index' : 'header-other' }}"
>
    <div class="header-l-c">
        <div class="header-left">
            <a class="logos" href="{{ route('user.military.index') }}" data-toggle="tooltip" title="Повернутись на головну">
                <img src="{{ asset('images/logo/logo_mini.svg') }}" alt="Logo">
            </a>
            <a id="add-icon" href="{{ route('user.military.create') }}" data-toggle="tooltip" title="Додати заявки">
                <img src="{{ asset('images/icon/znak.svg') }}" alt="Додати" >
            </a>
            <a id="history-icon" href="{{ route('user.military.view_app') }}" data-toggle="tooltip" title="Переглянути заявки">
                <img src="{{ asset('images/icon/history.svg') }}" alt="Історія" >
            </a>
        </div>
        <div class="header-center">
            <nav class="navbar-custom">
                @if(Route::currentRouteName() === 'user.military.index')
                    <a href="#home-section" class="nav-link active">Головна</a>
                    <a href="#actions-section" class="nav-link">Дії з заявками</a>
                    <a href="#analytics-section" class="nav-link">Аналітика</a>
                @elseif(Route::currentRouteName() === 'user.military.create')
                    <a class="head-name">Нова заявка</a>
                @elseif(Route::currentRouteName() === 'user.military.edit')
                    <a class="head-name">Редагування заявки</a>
                @elseif(Route::currentRouteName() === 'user.military.edit_account')
                    <a class="head-name">Редагування персональної інформації</a>
                @elseif(Route::currentRouteName() === 'military.rate')
                    <a class="head-name">Виставлення рейтингу</a>
                @elseif(Route::currentRouteName() === 'user.military.view_account')
                    <a class="head-name">Особистий кабінет</a>
                @elseif(Route::currentRouteName() === 'user.military.view_app')
                    <a class="head-name">Перегляд створених заявок</a>
                @elseif(Route::currentRouteName() === 'user.military.vol.view_volunteer')
                    <a class="head-name">Перегляд списку волонтерів</a>
                @elseif(Route::currentRouteName() === 'user.military.account.edit_photo')
                    <a class="head-name">Редагування фото профілю</a>
                @elseif(Route::currentRouteName() === 'user.military.images.edit')
                    <a class="head-name">Редагування фото заявки</a>
                @elseif(Route::currentRouteName() === 'user.military.images.create')
                    <a class="head-name">Додавання фото до заявки</a>
{{--                @elseif(Route::currentRouteName() === 'user.military.vol.old_volunteer')--}}
{{--                    <a class="head-name">Волонтери, з якими вже співпрацювали</a>--}}
                @else
                    <a class="nav-link">Назад</a>
                @endif
            </nav>
        </div>


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

            <div id="burger-menu" class="burger-menu">
                <a class="details-items" href="{{ route('user.military.view_account') }}">
                    <img src="{{ asset('images/icon/info.svg') }}">
                    Особистий кабінет
                </a>

                <form class="details-items" method="POST" action="{{ route('logout') }}">
                    @csrf
                    <img src="{{ asset('images/icon/logout.svg') }}">
                    <button type="submit" class="button-log" onclick="return confirmLogout()">
                        Вийти з акаунту
                    </button>
                </form>
            </div>
    </div>



</header>

<div class="container" style="max-width: 1800px;">
    @yield('content')
</div>


<style>

    section {
        scroll-margin-top: 120px;
    }

    html {
        scroll-behavior: smooth;
    }

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
    .header-index .header-l-c {
        display: flex;
        align-items: start;
        gap: 400px;
    }

    /* --- Стилі для інших сторінок: центрування --- */
    .header-other .header-l-c {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0;
        width: 100%;
    }

    /* Центруємо навігацію між лівим і правим блоком */
    .header-other .header-center {
        margin-left: auto;
        margin-right: auto;
    }

    .header-l-c{
        display: flex;
        align-items: start;
        gap: 350px;
        max-width: calc(100% - 200px); /* залишаємо місце для header-right */
        flex-shrink: 1;
    }

    .header-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .logos img {
        height: 60px;
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
        flex-shrink: 0; /* не звужуватись */
        display: flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
    }

    .text-log{
        color: var(--black-my);
        font-size: 18px;
        font-weight: 600;
        line-height: 27px;
        word-wrap: break-word
    }

    .head-name{
        color: var(--orange-my);
        font-size: 20px;
        font-weight: 600;
        line-height: 27px;
        word-wrap: break-word;
        text-decoration: none;
    }
    .head-name:hover{
        color: var(--orange-my);
        font-size: 20px;
        font-weight: 600;
        line-height: 27px;
        word-wrap: break-word;
        text-decoration: none;
    }

    @media (max-width: 768px) {

        .logos img {
            height: 40px;
            width: auto;
        }

        img {
            height: 24px;
            width: auto;
        }

        .header-military {
            flex-direction: row;
            justify-content: space-between;
        }

        .header-l-c{
            flex-direction: row;
            gap: 8px;
        }

        .header-center {
            display: none;
        }
        .navbar-custom{
            gap: 2px;
        }
    }



    .burger-menu {
        display: none;
        position: fixed;
        right: -300px;
        top: 100px;
        width: min-content;
        background-color: var(--yellow-my);
        border-radius: 16px;
        color: var(--black-my);
        transition: right 0.3s ease;
        z-index: 1000;
        flex-direction: column;
        justify-content: start;
        align-items: start;
        gap: 16px;
        padding: 16px;
    }

    .burger-menu.open {
        display: flex;
        right: 0;
    }

    @media (max-width: 768px) {

        .burger-menu {
            top: 74px;
        }
    }



    .details-items {
        display: flex;
        flex-direction: row;
        text-align: left;
        align-items: center;
        color: var(--green-dark);
        gap: 16px;
        font-size: 16px;
        font-weight: 400;
        line-height: 27px;
        white-space: nowrap;
    }

    .details-items:hover {
        color: var(--black-my);
    }

    .button-log{
        background: none;
        border: none;
        color: inherit;
        cursor: pointer;
        padding: 0;
        width: 100%;
        display: flex;
        flex-direction: row;
        text-align: left;
        align-items:start;
        gap: 16px;
        font-size: 16px;
        font-weight: 400;
        line-height: 27px;
        white-space: nowrap;
    }
</style>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    function confirmLogout() {
        return confirm("Ви дійсно бажаєте вийти з акаунта?");
    }

    document.addEventListener("DOMContentLoaded", function () {
        const sections = document.querySelectorAll("section[id]");
        const navLinks = document.querySelectorAll(".navbar-custom .nav-link");

        function activateNavLink() {
            let scrollY = window.pageYOffset;

            sections.forEach((current) => {
                const sectionTop = current.offsetTop - 130; // враховуємо висоту header
                const sectionHeight = current.offsetHeight;
                const sectionId = current.getAttribute("id");

                if (scrollY >= sectionTop && scrollY < sectionTop + sectionHeight) {
                    navLinks.forEach((link) => {
                        link.classList.remove("active");
                        if (link.getAttribute("href") === `#${sectionId}`) {
                            link.classList.add("active");
                        }
                    });
                }
            });
        }

        window.addEventListener("scroll", activateNavLink);
    });

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






</script>
</body>
</html>
