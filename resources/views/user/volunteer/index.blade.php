@extends('layouts.app')
@include('layouts.header_volunteer')
@section('content')<meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="main-content" style="font-family: 'Open Sans', sans-serif;">
        <section class="block-one" id="home-section" style="font-family: 'Open Sans', sans-serif;">
            <div class="left-title">
                <div class="title">
                    <h2 class="title-one">Косметологічна допомога</h2>
                    <h2 class="title-two">військовим</h2>
                </div>
                <p class="subtitle">Солідарність у боротьбі: ваша підтримка - наша сила.</p>
                <div class="button-row">
                    <a class="btn-create" href="{{ route('user.volunteer.view_app') }}"> Переглянути заявки </a>
                </div>
            </div>
            <div class="right-image">
                <img src="{{ asset('images/logo/image_military.svg') }}" alt="Image-Military">
            </div>
        </section>

        <section class="block-two" id="actions-section">
            <div class="action-block" style="border-bottom: 1px solid var(--blue-my);">
                <a type="submit" class="action-button" href="{{ route('user.volunteer.confirm.view_confirm_app') }}">
                    <img src="{{ asset('images/icon/sidebar/list.svg') }}" >
                    Перегляд підтверджених заявок
                </a>
                <div class="title-action-block" >
                    Ви можете <span class="highlight-action">переглянути заявки,</span> які підтвердили
                </div>
            </div>
            <div class="action-block-2" style="border-bottom: 1px solid var(--blue-my);">

                <a type="submit" class="action-button" href="{{ route('user.volunteer.view_app') }}">
                    <img src="{{ asset('images/icon/history.svg') }}" >
                    Перегляд заявок
                </a>
                <div class="title-action-block-2" >
                    Перегляньте <span class="highlight-action">усі заявки</span> військових
                </div>
            </div>
            <div class="action-block">
                <a type="submit" class="action-button" href="{{ route('user.volunteer.mil.view_military')}}">
                    <img src="{{ asset('images/icon/list.svg') }}" >
                    Перегляд списку військових
                </a>
                <div class="title-action-block" >
                    Перегляньте <span class="highlight-action">список військових</span> яким ви можете допомогти
                </div>
            </div>
        </section>

        <div class="application-block" id="application-card-container">
            @if($applications->isEmpty())
                <p>Немає термінових заявок</p>
            @else
                @foreach ($applications as $application)
                    @include('components.application-card-vol', ['application' => $application])
                @endforeach
            @endif
        </div>

        <section class="block-three" id="analytics-section" >
            <h2 class="title-analytics">Досягнення</h2>
            <div class="analytics">
                <div class="analytics-block">
                    <p class="analytics-number" data-target="{{ $totalApplications }}">0</p>
                    <p class="analytics-label">заявки я підтвердив</p>
                </div>
{{--                <div class="analytics-block">--}}
{{--                    <p class="analytics-number" data-target="{{ $acceptedApplications }}">0</p>--}}
{{--                    <p class="analytics-label">заявок виконано</p>--}}
{{--                </div>--}}
{{--                <div class="analytics-block">--}}
{{--                    <p class="analytics-number" data-target="2">0%</p>--}}
{{--                    <p class="analytics-label">заявки відхилено</p>--}}
{{--                </div>--}}
            </div>
        </section>
    </div>


{{--    <div class="scrollable-application-list">--}}
{{--        <h3 class="scrollable-title">Термінові заявки</h3>--}}
{{--        @if($urgentOrCreatedApplications->isNotEmpty())--}}
{{--            @foreach($urgentOrCreatedApplications as $application)--}}
{{--                <div class="application-item">--}}
{{--                    <a href="{{ route('user.volunteer.confirm_application', $application->id) }}" class="application-title">--}}
{{--                        {{ $application->title }}--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--            @endforeach--}}
{{--        @else--}}
{{--            <p class="no-applications">Немає заявок, що відповідають умовам.</p>--}}
{{--        @endif--}}
{{--    </div>--}}



    @include('layouts.footer')
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
            flex-direction: column-reverse;
            padding: 32px 24px;
        }

        .left-title {
            align-items: center;
            text-align: center;
            gap: 16px;
        }

        .title {
            align-items: center;
            justify-content: center;
        }

        .title-one,
        .title-two {
            font-size: 28px;
            line-height: 32px;
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
            width: min-content;
            text-align: center;
            white-space: nowrap;
        }

        .right-image {
            width: 100%;
            margin-top: 0;
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
        line-height: 130%;
        word-wrap: break-word;
        color: var(--main-green-dark);
        text-align: left;
    }

    .title-action-block-2 {
        width: 550px;
        font-size: 32px;
        font-weight: 600;
        line-height: 130%;
        word-wrap: break-word;
        color: var(--main-green-dark);
        text-align: right;
    }

    .title-action-block .highlight-action {
        background-image: linear-gradient(90deg, #556B2F 0%, #D97706 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .title-action-block-2 .highlight-action {
        background-image: linear-gradient(90deg, #556B2F 0%, #D97706 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    @media (max-width: 768px) {
        .block-two {
            padding: 24px;
        }
        .action-button {
            width: 100%;
        }

        .action-block{
            gap: 16px;
        }

        .action-block-2{
            flex-direction: row;
            gap: 16px;
        }

        .title-action-block, .title-action-block-2 {
            font-size: 20px;
            text-align: center;
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
        line-height: 130%;
        margin: 0;
    }


    .analytics {
        display: flex;
        justify-content: center;
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
        line-height: 130%;
        color: var(--black-my);
    }
    .analytics-label {
        font-size: 24px;
        font-weight: 400;
        line-height: 130%;
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

    @media (max-width: 768px) {
        .block-three {
            width: 100%;
            margin: 32px 0;
            display: inline-flex;
            justify-content: space-between;
            flex-direction: column;
            align-items: center;
            padding: 20px 24px;
            gap: 24px;
        }

        .title-analytics{
            font-size: 24px;
            text-align: center;
        }

        .analytics {
            padding: 0;
            flex-wrap: wrap;
            justify-content: center;
            gap: 8px;
            align-items: center;
        }
        .analytics-number {
            font-size: 40px;
            margin: 0;
        }
        .analytics-label {
            width: 150px;
            font-size: 20px;
            margin: 0;
        }
    }

    .application-block{
        width: 100%;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 36px;
        padding: 64px 80px;
    }

    @media (max-width: 768px) {

        .application-block{
            gap: 12px;
            padding: 24px;
        }
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
