@extends('layouts.app')
@include('layouts.header_landing')
<body><link href="{{ asset('css/icon.css') }}" rel="stylesheet">
<link href="{{ asset('css/global.css') }}" rel="stylesheet">

</body>


@section('content')
    <div class="main-content" style="font-family: 'Open Sans', sans-serif;">
        <div class="block-one" style="font-family: 'Open Sans', sans-serif;">
            <div class="left-title">
                <div class="title">
                    <h2 class="title-one">Косметологічна допомога</h2>
                    <h2 class="title-two">військовим</h2>
                </div>
                <p class="subtitle">Солідарність у боротьбі: ваша підтримка - наша сила.</p>
                <div class="button-row">
                    <a class="btn-more" href="#about-section"> Дізнатись більше </a>
                    <a class="btn-log" href="{{ url('auth/login') }}"> Увійти в акаунт </a>
                </div>
            </div>
            <div class="right-image">
                    <img src="{{ asset('images/logo/image_military.svg') }}" alt="Image-Military">
            </div>
        </div>

        <div class="block-two" id="help-section" >
            <h2 class="title-info">Військові публікують заявки зі своїми потребами - волонтери допомагають</h2>
            <p class="subtitle-info">Що ми можемо надати?</p>
            <div class="helps-info-block">
                <div class="helps-info">
                    <div class="helps-info-icon">
                        <object type="image/svg+xml" data="{{ asset('images/icon/landing_about.svg') }}" class="icon-helps"></object>
                    </div>
                    <p class="helps-title">Перша допомога</p>
                    <p class="helps-subtitle">Медикаменти, спідня білизна, засоби особистої гігієни</p>
                </div>
                <div class="helps-info">
                    <div class="helps-info-icon">
                        <object type="image/svg+xml" data="{{ asset('images/icon/landing_about-1.svg') }}" class="icon-helps"></object>
                    </div>
                    <p class="helps-title">Життєво необхідне</p>
                    <p class="helps-subtitle">Павербанки, ліхтарики, таблетки для очищення води</p>
                </div>
                <div class="helps-info">
                    <div class="helps-info-icon">
                        <object type="image/svg+xml" data="{{ asset('images/icon/landing_about-2.svg') }}" class="icon-helps"></object>
                    </div>
                    <p class="helps-title">Гігієна в польових умовах</p>
                    <p class="helps-subtitle">Серветки, мило, одноразові душі, зубні щітки</p>
                </div>
            </div>
        </div>

        <div class="block-three" id="analytics-section">
            <h2 class="title-analytics">Результати нашої роботи</h2>
            <div class="analytics">
                <div class="analytics-block">
                    <p class="analytics-number" data-target="{{ $totalApplications }}">0</p>
                    <p class="analytics-label">оформлених заявок</p>
                </div>
                <div class="analytics-block">
                    <p class="analytics-number" data-target="{{ $totalVolunteers }}">0</p>
                    <p class="analytics-label">активних волонтерів</p>
                </div>
                <div class="analytics-block">
                    <p class="analytics-number" data-target="{{ $completedPercentage }}" data-suffix="%">0%</p>
                    <p class="analytics-label">заявок опрацьовано</p>
                </div>
            </div>
        </div>


        <div class="block-four" id="about-section" >
            <div class="block-four-inside">
                <h2 class="title-block-why-us">Чому саме ми?</h2>
                <div class="why-us-info-block">
                    <div class="why-us-info">
                        <p class="why-us-title">Ефективність</p>
                        <p class="why-us-subtitle">Ми знаємо де взяти найкращі технології для наших військових та де вони найзатребуваніші. Тому допомагаємо ЗСУ.</p>
                    </div>
                    <div class="why-us-info">
                        <p class="why-us-title">100% на допомогу ЗСУ</p>
                        <p class="why-us-subtitle">Всі наші сили ми направляємо на допомогу військовим, щоб 100% донатів перетворювати на технології для ЗСУ.</p>
                    </div>
                    <div class="why-us-info">
                        <p class="why-us-title">Прозорість</p>
                        <p class="why-us-subtitle">Ми регулярно звітуємо на сайті та в соціальних мережах, як і на що ми витрачаємо ресурси та кошти для ЗСУ.</p>
                    </div>
                    <div class="why-us-info">
                        <p class="why-us-title">Єдність</p>
                        <p class="why-us-subtitle">Всі волонтери вже працюють з нами. Згрупувавшись усі разом - допомагаємо нашій армії.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="block-five" id="volunteer-section">
            <div class="volunteers-header">
                <div class="title-block-volunteer">
                    Наші <span class="highlight">волонтери</span> - завжди допоможуть та підтримають
                </div>
            </div>

            <div class="volunteer-block-outer">
                <div class="volunteer-block">
                    @foreach($volunteers as $volunteer)
                        <div class="volunteer-card">
                            <div class="img-vol">
                                @if($volunteer->images->isNotEmpty())
                                    @foreach ($volunteer->images as $image)
                                        <img  class="img1-icon" alt="" src="{{ asset('storage/' . $image->image_url) }}" />
                                    @endforeach
                                @else
                                    <p>No images available for this volunteer.</p>
                                @endif
                            </div>
                            <div class="text-block-volunteer">
                                <div class="volunteer-name">
                                    <b>{{ $volunteer->name }} {{ $volunteer->surname }}</b>
                                </div>
                                <div class="volunteer-text-more">
                                    <b>{{ $volunteer->phone }}</b>
                                    <b>{{ $volunteer->email }}</b>
                                </div>
                            </div>
                        </div>

                    @endforeach
                </div>
            </div>
        </div>



    </div>

        @include('layouts.footer_landing')


    <style>
        body {
            overflow-x: hidden;
        }

        * {
            box-sizing: border-box;
        }


        .main-content {
            background-color: var(--main-white);
            max-width: 100%;
            margin: 0 auto;
        }

        .block-one {
            width: 100%;
            margin: 0;
            display: inline-flex;
            background-image: linear-gradient(132deg, #F1F1DE 0%, #FDFDF6 69%);
            justify-content: space-between;
            align-items: center;
            padding: 64px 190px;
            flex-wrap: wrap;
        }

        .left-title {
            display: inline-flex;
            justify-content: flex-start;
            flex-direction: column;
            align-items: flex-start;
            gap: 32px;
        }

        .title {
            display: inline-flex;
            justify-content: flex-start;
            flex-direction: column;
            align-items: flex-start;
            gap: 0;
        }

        .title-one {
            background-image: linear-gradient(90deg, #556B2F 0%, #D97706 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: inline-block;
            font-size: 48px;
            font-weight: 600;
            line-height: 56px;
            margin: 0;
        }

        .title-two {
            color: var(--black-my);
            display: inline-block;
            font-size: 48px;
            font-weight: 600;
            line-height: 56px;
            margin: 0;
        }

        .subtitle {
            color: var(--green-dark);
            display: inline-block;
            font-size: 18px;
            font-weight: 600;
            margin: 0;
        }

        .button-row {
            display: inline-flex;
            justify-content: flex-start;
            flex-direction: row;
            align-items: flex-start;
            gap: 24px;
        }

        .btn-more {
            display: flex;
            align-items: center;
            justify-content: center;
            width: auto;
            height: auto;
            background-color: var(--main-green-dark);
            border-radius: 16px;
            color: var(--main-white);
            font-size: 16px;
            font-weight: 600;
            line-height: 24px;
            padding: 12px 24px;
            text-align: center;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.5s ease, color 0.5s ease;
        }

        .btn-more:hover {
            background-color: var(--green-dark);
            color: var(--main-white);
            text-decoration: none;
            transform: scale(1.1);
        }

        .btn-log {
            display: flex;
            align-items: center;
            justify-content: center;
            width: auto;
            height: auto;
            background-color: transparent;
            border: 1px solid var(--main-green-dark);
            border-radius: 16px;
            color: var(--main-green-dark);
            font-size: 16px;
            font-weight: 600;
            line-height: 24px;
            padding: 12px 24px;
            text-align: center;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.5s ease, color 0.5s ease;
        }

        .btn-log:hover {
            background-color: var(--green-dark);
            border: 1px solid var(--green-dark);
            color: var(--main-white);
            text-decoration: none;
            transform: scale(1.1);
        }

        /* === Адаптивність для мобільних === */
        @media (max-width: 768px) {
            .block-one {
                flex-direction: column;
                padding: 32px 24px;
            }

            .left-title {
                align-items: center;
                text-align: center;
                gap: 24px;
            }

            .title {
                align-items: center;
                justify-content: center;
            }

            .title-one,
            .title-two {
                font-size: 36px;
            }

            .subtitle {
                font-size: 16px;
            }

            .button-row {
                flex-direction: column;
                align-items: center;
                gap: 16px;
            }

            .btn-more,
            .btn-log {
                width: 100%;
                text-align: center;
            }

            .right-image {
                width: 100%;
                margin-top: 24px;
                display: flex;
                justify-content: center;
            }

            .right-image img {
                width: 80%;
                height: auto;
            }
        }








        .block-two {
            width: calc(100vw - 160px);
            margin: 64px 80px;
            display: inline-flex;
            background-image: linear-gradient(128deg, #A3B18A 0%, #AEC6CF 100%);
            justify-content: space-between;
            flex-direction: column;
            align-items: center;
            padding: 60px 110px;
            gap: 24px;
            box-sizing: border-box;
            border-radius: 16px;
        }

        .title-info{
            color: var(--green-dark);
            display: inline-block;
            font-size: 48px;
            font-weight: 600;
            line-height: 56px;
            margin: 0;
            text-align: center;
            word-wrap: break-word;
        }
        .subtitle-info{
            color: var(--black-my);
            display: inline-block;
            font-size: 32px;
            font-weight: 600;
            margin: 0;
        }

        .helps-info-block{
            display: flex;
            justify-content: center;
            padding: 0;
            align-items: center;
            width: 100%;
            gap: 96px;

        }
        .helps-info {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            text-align: left;
            gap: 16px;
        }
        .helps-info:hover, .why-us-info:hover, .analytics-block:hover{
            transform: scale(1.1);
        }

        .helps-info-icon{
            padding: 10px;
            background-color: var(--orange-my);
            border-radius: 16px;
            width: 60px;
            height: 60px;
        }
        .helps-title{
            font-size: 24px;
            font-weight: 600;
            line-height: 36px;
            color: var(--black-my);
            margin: 0;
        }
        .helps-subtitle{
            font-size: 20px;
            font-weight: 400;
            line-height: 30px;
            color: var(--green-dark);
            margin: 0;
            word-wrap: break-word;
            width: 318px;
            height: auto;
        }
        @media (max-width: 768px) {
            .block-two {
                width: calc(100vw - 48px);
                margin: 32px 24px;
                padding: 40px 24px;
            }

            .title-info {
                font-size: 36px;
                line-height: 44px;
            }

            .subtitle-info {
                font-size: 24px;
                text-align: center;
            }

            .helps-info-block {
                flex-direction: column;
                gap: 32px;
            }

            .helps-info {
                align-items: center;
                text-align: center;
            }

            .helps-subtitle {
                width: 100%;
            }
        }




        .block-three {
            width: 100%;
            margin: 64px 0;
            display: inline-flex;
            background-color: var(--orange-my);
            justify-content: space-between;
            flex-direction: column;
            align-items: center;
            padding: 40px 190px;
            gap: 32px;
        }
        .title-analytics{
            color: var(--black-my);
            display: inline-block;
            font-size: 48px;
            font-weight: 600;
            line-height: 56px;
            margin: 0;
        }

        .analytics {
            display: flex;
            justify-content: space-between;
            padding: 0px 116px;
            align-items: center;
            width: 100%;
        }
        .analytics-block {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        .analytics-number {
            font-size: 58px;
            font-weight: 600;
            line-height: 75.40px;
            color: var(--black-my);
        }
        .analytics-label {
            font-size: 24px;
            font-weight: 400;
            line-height: 31.20px;
            color: var(--black-my);
            word-wrap: break-word;
            width: 183px;
        }



        .block-four {
            width: 100%;
            margin: 64px auto;
            display: inline-flex;
            background: url("{{ asset('images/logo/why-us.svg') }}") center/cover no-repeat;
            background-size: cover;
            background-position: center;
            flex-direction: column;
            align-items: center;
            gap: 48px;
            box-sizing: border-box;
            justify-content: space-between;
            padding: 40px 80px;
        }

        .block-four-inside {
            width: 100%;
            margin: 0 auto;
            display: inline-flex;
            background-color: rgba(253, 253, 246, 0.80);
            flex-direction: column;
            align-items: center;
            backdrop-filter: blur(10px);
            border-radius: 16px;
            gap: 48px;
            box-sizing: border-box;
            justify-content: space-between;
            padding: 40px 110px;
        }
        .title-block-why-us{
            color: var(--orange-my);
            display: inline-block;
            font-size: 48px;
            font-weight: 600;
            line-height: 62.40px;
            word-wrap: break-word;
            margin: 0;
            text-align: center;
        }

        .why-us-info-block{
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 24px;
        }

        .why-us-info{
            flex: 0 1 calc(50% - 12px);
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            text-align: left;
            gap: 8px;
        }
        .why-us-title{
            margin: 0;
            color: var(--green-dark);
            font-size: 28px;
            font-weight: 600;
            line-height: 36.40px;
            word-wrap: break-word
        }
        .why-us-subtitle{
            margin: 0;
            color: var(--main-green-dark);
            font-size: 20px;
            font-weight: 400;
            line-height: 26px;
            word-wrap: break-word
        }




        .block-five {

            padding: 64px 80px;
            width: 100%;
            display: inline-flex;
            justify-content: space-between;
            flex-direction: column;
            align-items: center;
            gap: 40px;
            box-sizing: border-box;
            border-radius: 16px;
        }

        .title-block-volunteer {
            width: 1080px;
            font-size: 48px;
            font-weight: 600;
            line-height: 56px;
            word-wrap: break-word;
            color: var(--main-green-dark);
            text-align: center;
        }
        .title-block-volunteer .highlight {
            background-image: linear-gradient(90deg, #556B2F 0%, #D97706 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .volunteer-block-outer {
            width: 100%;
            overflow-x: auto;
            overflow-y: visible;
            padding-top: 100px;
            padding-bottom: 20px;
        }
        .volunteer-block {
            display: flex;
            justify-content: center;
            flex-direction: row;
            align-items: flex-start;
            gap: 36px;
            padding: 0;
            white-space: nowrap;
        }

        .volunteer-block-outer::-webkit-scrollbar {
            height: 8px;
        }
        .volunteer-block-outer::-webkit-scrollbar-thumb {
            background-color: var(--green-dark);
            border-radius: 4px;
        }
        .volunteer-block-outer::-webkit-scrollbar-track {
            background: transparent;
        }

        .volunteer-card{
            position: relative;
            display: flex;
            justify-content: space-between;
            flex-direction: column;
            padding: 0;
            align-items: center;
            flex: 0 0 calc((100% - 3 * 36px) / 4); /* 4 картки + 3 відступи між ними */
            max-width: calc((100% - 3 * 36px) / 4); /* Додатково обмежуємо максимальну ширину */
        }
        .img-vol{
            width: 183px;
            height: 183px;
            position: absolute;
            top: -96px;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .img-vol img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .text-block-volunteer{
            background-color: var(--beige-light);
            border-radius: 16px;
            display: flex;
            justify-content: space-between;
            flex-direction: column;
            padding: 16px;
            padding-top: 96px;
            align-items: center;
            text-align: center;
            width: 100%;
            gap: 24px;
        }
        .volunteer-name{
            color: var(--black-my);
            font-size: 24px;
            font-weight: 600;
            line-height: 31.20px;
            word-wrap: break-word;
        }
        .volunteer-text-more{
            color: var(--green-dark);
            font-size: 18px;
            font-weight: 400;
            line-height: 23.40px;
            word-wrap: break-word;
            display: flex;
            justify-content: space-between;
            flex-direction: column;
        }




    </style>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const animateNumber = (element, target, suffix = "", duration = 2000) => {
                let start = 0;
                const startTime = performance.now();

                const update = (now) => {
                    const elapsed = now - startTime;
                    const progress = Math.min(elapsed / duration, 1);
                    const value = Math.floor(progress * target);
                    element.textContent = value + suffix;
                    if (progress < 1) {
                        requestAnimationFrame(update);
                    }
                };

                requestAnimationFrame(update);
            };

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        const numbers = entry.target.querySelectorAll(".analytics-number");
                        numbers.forEach((num) => {
                            const target = parseInt(num.dataset.target, 10);
                            const suffix = num.dataset.suffix || "";
                            animateNumber(num, target, suffix);
                        });
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.5 });

            const analyticsSection = document.getElementById("analytics-section");
            if (analyticsSection) {
                observer.observe(analyticsSection);
            }
        });
    </script>
@endsection






