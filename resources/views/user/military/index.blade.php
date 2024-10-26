    @extends('layouts.app')
    @include('layouts.header_military_notsearch')
    @section('content')
        <img class="background" src="{{ asset('images/back-image.png') }}" alt="">
        <div class="main-content" style="font-family: 'Jura', sans-serif;">
            <div class="block">
                <div class="infos">
                    <div class="info">
                        <div class="info-block">
                            <h1 class="title"  >Подання заявки</h1>
                            <h3 class="subtitle">Ви можете оформити заявку про допомогу </h3>
                        </div>
                        <img class="info-image" alt="" src="{{ asset('images/info-image-1.png') }}">
                    </div>
                    <a class="ic--round-play-arrow" style="color: var(--green-800); font-size: 47px; " href="{{ route('user.military.create') }}" ></a>

                </div>
                <div class="infos">
                    <div class="info">
                        <div class="info-block">
                            <h1 class="title">Перегляд історії заявок</h1>
                            <h3 class="subtitle">Ви можете переглядати свої опубліковані заявки</h3>
                        </div>
                        <img class="info-image" alt="" src="{{ asset('images/info-image-2.png') }}">
                    </div>
                    <a class="ic--round-play-arrow" style="color: var(--green-800); font-size: 47px; " href="{{ route('user.military.view_app') }}"></a>
                </div>
                <div class="infos">
                    <div class="info">
                        <div class="info-block">
                            <h1 class="title">Перегляд списку волонтерів</h1>
                            <h3 class="subtitle">Ви можете переглядати список усіх волонтерів</h3>
                        </div>
                        <img class="info-image" alt="" src="{{ asset('images/info-image-3.png') }}">
                    </div>
                    <a class="ic--round-play-arrow" style="color: var(--green-800); font-size: 47px; "  href="{{ route('user.military.view_volunteer')}}"></a>
                </div>
            </div>
            <div class="title-name">
                <b style=" color: var(--green-800); text-shadow: 0.5px 0 0 var(--green-800), 0 0.5px 0 var(--green-800), -0.5px 0 0 var(--green-800), 0 -0.5px 0 var(--green-800);" class="b">КОСМЕТОЛОГІЧНА </b>
                <b style=" color: var(--green-500); text-shadow: 0.5px 0 0 var(--green-500), 0 0.5px 0 var(--green-500), -0.5px 0 0 var(--green-500), 0 -0.5px 0 var(--green-500);" class="b1">ДОПОМОГА</b>
                <b style=" color: var(--green-800); text-shadow: 0.5px 0 0 var(--green-800), 0 0.5px 0 var(--green-800), -0.5px 0 0 var(--green-800), 0 -0.5px 0 var(--green-800);" class="b2">ВІЙСЬКОВИМ</b>
                <div class="info-container">
                    <div class="bl-info">
                        <div class="info-number-circle">
                            <span>{{ $totalApplications }}</span>
                        </div>
                        <p class="info-text">
                            <strong>Загальна кількість заявок:</strong>
                        </p>
                    </div>

                    <div class="bl-info">
                        <div class="info-number-circle">
                            <span>{{ $acceptedApplications }}</span>
                        </div>
                        <p class="info-text">
                            <strong>Прийняті заявки волонтерами:</strong>
                        </p>
                    </div>
                </div>


            </div>
        </div>

        @include('layouts.footer_military')
    @endsection

    <style>
        body {
            overflow-x: hidden;
        }

        * {
            box-sizing: border-box;
        }
        .background {
            position: absolute; /* Абсолютне позиціонування, щоб залишалась зверху */
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh; /* Висота в 100% висоти видимої частини екрану */
            object-fit: cover; /* Збереження пропорцій зображення */
            z-index: -1; /* Фон залишається за контентом */
        }

        .title-name {
            position: relative;
            width: 45%;
            font-size: 76px;
            padding: 48px 0px ;

        }
        .b, .b1, .b2 {
            font-weight: bold;
            margin-bottom: 10px; /* Зменшуємо відступи між елементами */
        }

        .main-content {
            font-family: 'Arial', sans-serif;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            margin: 0; /* Відмінити відступи з боків */
            max-width: 1400px; /* Встановіть максимальну ширину */
            gap: 50px;
        }

        .info-block {
            width: 100%;
            position: relative;
            border-radius: 40px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            text-align: left;
            font-size: var(--medium-24-8-size);
            color: var(--green-800);
        }

        .info {
            width: 100%;
            position: relative;
            border-radius: 10px;
            padding: 10px;
            box-sizing: border-box;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            font-size: var(--bold-28-8-size);
            background-color: var(--green-300);
            gap: 10px;
            margin-left: 20px;
            margin-bottom: 15px;transition: background-color 0.3s ease, color 0.3s ease; /* Анімація зміни кольору */
        }

        .info:hover {
            background-color: var(--green-500);
            text-decoration: none;
            transform: scale(1.05);
        }

        .infos {
            width: 100%;
            position: relative;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            font-size: var(--bold-28-8-size);
            gap: 10px;
        }

        .info-image {
            width: 30%;
            height: 30%;
            border-radius: 10px;
        }

        .block {
            width: 55%;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            font-size: var(--bold-28-8-size);
            gap: 10px;
            padding: 48px 0px ;
        }




        .info-container {
            display: flex;
            gap: 20px;
            justify-content: flex-start;
            padding: 10px;
            margin-top: 35px;
        }

        .bl-info {
            width: 40%;
            height: 160px;
            position: relative;
            border-radius: 10px;
            padding: 0 20px;

            font-size: var(--bold-28-8-size);
            background-color: var(--green-300);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s ease, color 0.3s ease;
            overflow: hidden;
        }

        .bl-info:hover {
            background-color: var(--green-500);
            text-decoration: none;
            transform: scale(1.05);
        }

        .info-number-circle {
            position: absolute;
            bottom: -10px; /* Розміщення знизу */
            right: -17px; /* Розміщення праворуч */
            width: 78px;
            height: 78px;
            background-color: var(--yellow-200);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            font-weight: bold;
            color: var(--green-800);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .info-text {
            color: var(--green-800);
            font-size: 24px;
            font-weight: 500;
            margin-top: 20px;
        }

        .bl-info::before {
            content: "";
            position: absolute;
            top: 10px; /* Відступ зверху */
            left: 10px; /* Відступ зліва */
            height: 4px; /* Товщина лінії */
            width: 60px; /* Довжина горизонтальної лінії */
            background-color: var(--yellow-200);
        }

        .bl-info::after {
            content: "";
            position: absolute;
            top: 10px; /* Відступ зверху */
            left: 10px; /* Відступ зліва */
            width: 4px; /* Товщина лінії */
            height: 60px; /* Довжина вертикальної лінії */
            background-color: var(--yellow-200);
        }





    </style>

    <script>
        // Масив фонових зображень
        const backgrounds = [
            '{{ asset('images/лендінг/background1.png') }}',
            '{{ asset('images/лендінг/background2.png') }}',
            '{{ asset('images/лендінг/background3.png') }}'
        ];

        let currentIndex = 0;

        function changeBackground() {
            currentIndex = (currentIndex + 1) % backgrounds.length; // Змінюємо індекс
            document.querySelector('.background-icon').src = backgrounds[currentIndex]; // Змінюємо фонове зображення
        }

        // Змінюємо фон кожні 5 секунд
        setInterval(changeBackground, 5000);
    </script>
