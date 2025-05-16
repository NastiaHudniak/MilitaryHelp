    @extends('layouts.app')
    @include('layouts.header_military')


    @section('content')
        <link rel="stylesheet" href="{{ asset('css/alerts.css') }}">
        <div class="main-content" style="font-family: 'Open Sans', sans-serif;">
            @if($confirmedApplications->count())
                @php
                    $latestApp = $confirmedApplications->last();
                @endphp
                <div class="alert-success-custom" id="confirmed-alert">
                    <div class="alert-success-custom-text-block">
                        <p class="alert-success-custom-text">
                            Ваша заявка <strong>"{{ $latestApp->title }}"</strong> була підтверджена волонтером
                            <strong>{{ $latestApp->volunteer?->surname }} {{ $latestApp->volunteer?->name }}</strong>.
                        </p>
                        <p>Чи хочете ви поставити рейтинг цьому волонтеру?</p>
                        <div class="buttons-all">
                            <div class="buttons-mess">
                                <a href="{{ route('military.rate', $latestApp) }}"  class="alert-ok-btn">Так, оцінити</a>
                                <a href="{{ route('military.index') }}"  class="alert-no-btn">Ні, дякую</a>
                            </div>
                            <button class="alert-ok-btn" onclick="document.getElementById('confirmed-alert').style.display='none'">OK</button>
                        </div>

                    </div>

                </div>
            @endif



            <div class="block-one" style="font-family: 'Open Sans', sans-serif;">
                <div class="left-title">
                    <div class="title">
                        <h2 class="title-one">Косметологічна допомога</h2>
                        <h2 class="title-two">військовим</h2>
                    </div>
                    <p class="subtitle">Солідарність у боротьбі: ваша підтримка - наша сила.</p>
                    <div class="button-row">
                        <a class="btn-create" href="{{ route('user.military.create') }}"> Створити заявку </a>
                    </div>
                </div>
                <div class="right-image">
                    <img src="{{ asset('images/logo/image_military.svg') }}" alt="Image-Military">
                </div>
            </div>

            <div class="block-two">
                <div class="action-block" style="border-bottom: 1px solid var(--blue-my);">
                    <a type="submit" class="action-button" href="{{ route('user.military.create') }}">
                        <img src="{{ asset('images/icon/znak.svg') }}" >
                        Створення нової заявки
                    </a>
                    <div class="title-action-block" style="text-align: right">
                        Ви можете <span class="highlight-action">оформити заявку</span> про допомогу
                    </div>
                </div>
                <div class="action-block-2" style="border-bottom: 1px solid var(--blue-my);">

                    <a type="submit" class="action-button" href="{{ route('user.military.view_app') }}">
                        <img src="{{ asset('images/icon/history.svg') }}" >
                        Створення нової заявки
                    </a>
                    <div class="title-action-block" style="text-align: left">
                        Перегляньте <span class="highlight-action">свою історію</span> створених заявок
                    </div>
                </div>
                <div class="action-block">
                    <a type="submit" class="action-button" href="{{ route('user.military.vol.view_volunteer')}}">
                        <img src="{{ asset('images/icon/list.svg') }}" >
                        Створення нової заявки
                    </a>
                    <div class="title-action-block" style="text-align: right">
                        Перегляньте <span class="highlight-action">список волонтерів</span> які можуть вам допомогти
                    </div>
                </div>
            </div>

            <div class="block-three" id="analytics-section">
                <h2 class="title-analytics">Досягнення</h2>
                <div class="analytics">
                    <div class="analytics-block">
                        <p class="analytics-number" data-target="{{ $totalApplications }}">0</p>
                        <p class="analytics-label">заявки я опублікував</p>
                    </div>
                    <div class="analytics-block">
                        <p class="analytics-number" data-target="{{ $acceptedApplications }}">0</p>
                        <p class="analytics-label">заявок виконано</p>
                    </div>
                    <div class="analytics-block">
                        <p class="analytics-number" data-target="2">0%</p>
                        <p class="analytics-label">заявки відхилено</p>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footer_landing')
    @endsection

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

        .btn-create {
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

        .btn-create:hover {
            background-color: var(--green-dark);
            color: var(--main-white);
            text-decoration: none;
            transform: scale(1.1);
        }


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

            .btn-create{
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
            width: 100%;
            margin: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 64px 190px;
            flex-wrap: wrap;
            flex-direction: column;
        }

        .action-block{
            width: 100%;
            padding: 24px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            flex-direction: row;
        }
        .action-block-2{
            width: 100%;
            padding: 24px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            flex-direction: row-reverse;
        }
        .action-button {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0.75rem;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 16px;
            transition: all 0.3s ease-in-out;
            background-color: var(--main-beige);
            color: var(--green-dark);
            gap: 0.75rem;
        }

        .action-button:hover {
            background-color: var(--green-light);
            transform: scale(1.05);
            text-decoration: none;
            color: var(--green-dark);
        }

        .title-action-block {
            width: 550px;
            font-size: 32px;
            font-weight: 600;
            line-height: 48px;
            word-wrap: break-word;
            color: var(--main-green-dark);
            text-align: left;
        }
        .title-action-block .highlight-action {
            background-image: linear-gradient(90deg, #556B2F 0%, #D97706 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
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

        .buttons-all{
            display: flex;
            justify-content: space-between;
            flex-direction: row;
            width: 100%;
        }

        .buttons-mess{
            display: flex;
            justify-content: start;
            flex-direction: row;
            gap: 16px;
            padding: 6px 0;
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
