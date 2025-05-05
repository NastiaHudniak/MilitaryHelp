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

</head>
<body>
<footer class="footer ">
    <div class="row">
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="footer-logo">
                <img src="{{ asset('images/logo.jpg') }}" alt="Logo" style="width: 80px; height: auto; border-radius: 50%;">
                <h4 class="help" style="color: var(--yellow-500)">Military Help</h4>
                <p style="color: var(--yellow-200)">Ми допомагаємо військовим та волонтерам знайти необхідну допомогу.</p>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
            <h5 style="color: var(--yellow-500)">Навігація по сторінці</h5>
            <div class="list" style="color: var(--yellow-200)" >
                <a style="color: var(--yellow-200)" href="{{ route('user.military.create') }}" >Додати заявки</a>
                <a style="color: var(--yellow-200)" href="{{ route('user.military.view_app') }}">Переглянути заявки</a>
                <a style="color: var(--yellow-200)" href="{{ route('user.military.vol.view_volunteer') }}" >Переглянути список волонтерів</a>
            </div>
        </div>

        <!-- Social Media Links -->
        <div class="col-lg-4 col-md-12 mb-4">
            <h5 style="color: var(--yellow-500)">Соціальні мережі</h5>
            <div class="com">
                <a href="https://www.instagram.com/___aanastaasia___" >
                    <span class="iconoir--instagram" style=" font-size: 37px;"></span>
                </a>
                <a href="https://www.facebook.com/profile.php?id=100013498512633" >
                    <span class="mdi--facebook" style=" font-size: 37px;"></span>
                </a>
                <a href="https://t.me/nas_tia_a" >
                    <span class="ic--twotone-telegram" style=" font-size: 37px;"></span>
                </a>
                <a href="https://github.com/NastiaHudniak/MilitaryHelp" >
                    <span class="bi--github" style=" font-size: 30px;"></span>
                </a>
            </div>
        </div>
    </div>

    <hr class="bg-white">

    <!-- Footer Bottom Text -->
    <div class="row">
        <div class="col-md-6">
            <p class="text-white-50">&copy; 2024 Наша Компанія. Усі права захищено.</p>
        </div>
        <div class="col-md-6 text-md-right">
            <a href="{{ url('/privacy') }}" class="text-white-50">Політика конфіденційності</a>
            <span class="text-white-50 mx-2">|</span>
            <a href="{{ url('/terms') }}" class="text-white-50">Умови використання</a>
        </div>
    </div>
</footer>

<!-- Styles for Footer -->
<style>
    .footer {
        background-color: var(--green-800);
        padding: 20px 40px;
    }

    .footer-logo img {
        margin-bottom: 12px;
    }
    .footer p, .footer a {
        font-size: 16px;
        color: var(--yellow-200);
        text-decoration: none;
    }
    .footer a:hover {
        color: var(--yellow-400);
        text-decoration: underline;
    }
    .footer hr {
        border-color: var(--yellow-200);
    }

    .com{
        display: flex; /* Вмикаємо Flexbox */
        flex-direction: row; /* Розташовуємо елементи вертикально */
        gap: 30px;
    }

    .list{
        display: flex; /* Вмикаємо Flexbox */
        flex-direction: column; /* Розташовуємо елементи вертикально */
        gap: 30px;

    }


    .ic--twotone-telegram, .iconoir--instagram, .mdi--facebook, .bi--github{
        color: var(--yellow-200);
        transition: background-color 0.3s ease, color 0.3s ease; /* Анімація зміни кольору */

    }

    .ic--twotone-telegram:hover, .iconoir--instagram:hover, .mdi--facebook:hover, .bi--github:hover {
        color: var(--yellow-500);
        text-decoration: none; /* Без підкреслення при наведенні */
        transform: scale(1.1);
    }

</style>


<!-- Основний Контент -->
<div class="container" style="max-width: 1800px;">
    @yield('content')
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
