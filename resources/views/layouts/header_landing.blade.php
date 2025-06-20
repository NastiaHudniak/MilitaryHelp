<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <link href="{{ asset('css/icon.css') }}" rel="stylesheet">
    <link href="{{ asset('css/global.css') }}" rel="stylesheet">

</head>
<body>

<header class="header-admin">
    <div class="header-l-c">
        <div class="header-left">
            <a class="logos" href="#logos">
                <img src="{{ asset('images/logo/logo_mini.svg') }}" alt="Logo">
            </a>
        </div>
        <div class="header-center">
            <nav class="navbar-custom">
                <a href="#home-section" class="nav-link active">Головна</a>
                <a href="#help-section" class="nav-link">Допомога</a>
                <a href="#analytics-section" class="nav-link">Аналітика</a>
                <a href="#about-section" class="nav-link">Про нас</a>
                <a href="#volunteers-section" class="nav-link">Волонтери</a>
            </nav>
        </div>
    </div>

    <div class="header-right">
        <a class="login-button" href="{{ url('auth/login') }}">
            Увійти
        </a>
    </div>
</header>

<div class="container" style="max-width: 1800px;">
    @yield('content')
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const sections = document.querySelectorAll("section[id]");
        const navLinks = document.querySelectorAll(".navbar-custom .nav-link");

        function activateNavLink() {
            let scrollY = window.pageYOffset;

            sections.forEach((current) => {
                const sectionTop = current.offsetTop - 130;
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
</script>
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

    .header-l-c{
        display: flex;
        align-items: start;
        gap: 350px;
    }

    .header-left {
        display: flex;
        align-items: center;
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
        text-decoration: none;

    }

    @media (max-width: 768px) {
        img {
            height: 40px;
            width: auto;
        }

        .header-admin {
            flex-direction: row;
            gap: 16px;
        }

        .header-l-c{
            flex-direction: row;
            gap: 8px;
        }

        .header-center {
            display: none;
        }
        .navbar-custom{
            gap: 16px;
        }
        .login-button {
            width: 100%;
        }

        .navbar-custom .nav-link {
            padding: 0;
        }
        .navbar-custom .nav-link.active {
            padding: 0;
        }
    }

</style>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
