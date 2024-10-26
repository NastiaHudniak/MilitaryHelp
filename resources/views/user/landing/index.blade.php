@extends('layouts.app')
@include('layouts.header_landing')
<body><link href="{{ asset('css/icon.css') }}" rel="stylesheet">
<link href="{{ asset('css/global.css') }}" rel="stylesheet"></body>


@section('content')
    <img class="background-icon" src="{{ asset('images/лендінг/background1.png') }}" id="logos" alt="Background">
    <div class="main-content" style="font-family: 'Jura', sans-serif;">
        <div class="title-parent">
            <div class="title">
                <b style=" color: var(--green-200);" class="b">КОСМЕТОЛОГІЧНА </b>
                <b style=" color: var(--green-500);" class="b1">ДОПОМОГА</b>
                <b style=" color: var(--green-200);" class="b2">ВІЙСЬКОВИМ</b>
            </div>
            <div class="b3">Солідарність у боротьбі: ваша підтримка — наша сила.</div>
            <a class="learn-more-button" href="#about-section"> Дізнатись більше </a>
        </div>
        <img class="vector1-icon" alt="" src="{{ asset('images/лендінг/vector1.svg') }}">
        <img class="vector2-icon" alt="" src="{{ asset('images/лендінг/vector2.svg') }}">
        <div class="info-section" id="help-section">
            <div class="info-title" style="margin-top:40px;  ">
                ВІЙСЬКОВІ ПУБЛІКУЮТЬ ЗАЯВКИ ЗІ СВОЇМИ ПОТРЕБАМИ -
                <span class="highlight">ВОЛОНТЕРИ ДОПОМАГАЮТЬ</span>
            </div>
            <div style="color: var(--green-500)" href="{{ url('/auth/login') }}" class="service-title"> Що ми можемо надати? </div>
            <div class="services-list">

                <div class="service-item" style="font-size:25px">
                    <i class="fas fa-first-aid" style="font-size:40px"></i>
                    <p>Медикаменти, спідня білизна, засоби особистої гігієни</p>
                </div>
                <div class="service-item" style="font-size:25px">
                    <i class="fas fa-lightbulb" style="font-size:40px"></i>
                    <p>Павербанки, ліхтарики, таблетки для очищення води</p>
                </div>
                <div class="service-item" style="font-size:25px">
                    <i class="fas fa-shower" style="font-size:40px"></i>
                    <p>Засоби гігієни, в тому числі одноразові душі</p>
                </div>

            </div>
        </div>
        <img class="vector3-icon" alt="" src="{{ asset('images/лендінг/vector3.svg') }}">
        <div class="why-us-section" id="about-section">
            <div style="color: var(--yellow-500)"  class="reasons-title"> Чому саме ми? </div>
            <div class="reasons" style="font-size:22px">
                <div class="reason-item" >
                    <h3>Ефективність</h3>
                    <p>Ми знаємо де взяти найкращі технології для наших військових та де вони найзатребуваніші. Тому допомагаємо ЗСУ.</p>
                </div>
                <div class="reason-item">
                    <h3>100% на допомогу ЗСУ</h3>
                    <p>Всі наші сили ми направляємо на допомогу військовим, щоб 100% донатів перетворювати на технології для ЗСУ.</p>
                </div>
                <div class="reason-item">
                    <h3>Прозорість</h3>
                    <p>Ми регулярно звітуємо на сайті та в соціальних мережах, як і на що ми витрачаємо ресурси та кошти для ЗСУ.</p>
                </div>
                <div class="reason-item">
                    <h3>Єдність</h3>
                    <p>Всі волонтери вже працюють з нами. Згрупувавшись усі разом - допомагаємо нашій армії.</p>
                </div>
            </div>
        </div>

        <div class="volunteers-section" id="volunteers-section">
            <div style="color: var(--green-500)" class="volunteers-title"> Наші волонтери </div>
            <a style="color: var(--green-500); font-size: 30px" >Завжди допоможуть та підтримають</a>
            <div class="otziv-parent">
                @foreach($volunteers as $volunteer)
                    <div class="otziv">
                        <div class="img-text">
                            @if($volunteer->images->isNotEmpty())
                                @foreach ($volunteer->images as $image)
                                    <img  class="img1-icon" alt="" src="{{ asset('storage/' . $image->image_url) }}" />
                                @endforeach
                            @else
                                <p>No images available for this volunteer.</p>
                            @endif
                            <div class="header2" style="color: var(--green-800)">
                                <b class="b7">{{ $volunteer->name }} {{ $volunteer->surname }} </b>
                            </div>
                        </div>
                        <div class="header-text" style="color: var(--green-800)">
                            <div class="text-more">
                                <div class="div21">
                            <span>
                                <b>{{ $volunteer->phone }}</b>
                                <span class="span">{{ $volunteer->email }}</span>
                            </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
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
        color: #333;
        max-width: 1800px; /* Встановіть максимальну ширину */
        margin: 0 0; /* Центруйте контейнер */
    }
    .background-icon {
        position: absolute; /* Абсолютне позиціонування, щоб залишалась зверху */
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh; /* Висота в 100% висоти видимої частини екрану */
        object-fit: cover; /* Збереження пропорцій зображення */
        z-index: -1; /* Фон залишається за контентом */
    }



    .title-parent {
        height: 500px; /* Фіксована ширина */
        display: flex; /* Вмикаємо Flexbox */
        flex-direction: column; /* Розташовуємо елементи вертикально */
        justify-content: space-between; /* Рівномірно розподіляємо елементи */
        margin-bottom: 75px;
        margin-top: 65px;
    }
    .title {
        width: 770px;
        position: relative;
        height: 300px;
        font-size: 90px;
        margin: 0; /* Забираємо зайві відступи */
        padding: 0; /* Забираємо внутрішні відступи */
        line-height: 1.1; /* Можна зменшити інтерліньяж */
    }
    .b, .b1, .b2 {
        margin-left: 80px;
        font-weight: bold;
        margin-bottom: 10px; /* Зменшуємо відступи між елементами */
    }
    .b3 {
        width: 360px;
        height: 80px;
        position: relative;
        font-size: 24px;
        color: var(--yellow-200);
        flex-shrink: 0;
        margin-left: 80px;
    }
    .learn-more-button {
        width: 300px;
        height: 50px;
        margin-left: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: var(--yellow-400);
        color: var(--green-800);
        text-align: center;
        font-weight: 500;
        font-size: 24px;
        transition: background-color 0.3s ease, color 0.3s ease; /* Анімація зміни кольору */
    }

    .learn-more-button:hover {
        background-color: var(--green-500);
        color: var(--yellow-200);
        text-decoration: none;
        transform: scale(1.1);
    }

    .info-title {
        width: 1000px;
        font-weight: 600;
        text-align: center;
        font-size: 60px;
        color: var(--green-800);
        flex-shrink: 0;
        margin: 0 auto;
        line-height: 1.2;
        position: relative;
    }
    .highlight {
        background-color: var(--yellow-400);
        color: var(--green-800);
        padding: 0 10px;
        border-radius: 10px;
    }

    .service-title, .reasons-title, .volunteers-title {
        width: 100%;
        position: relative;
        font-size: 56px;
        letter-spacing: 0.08em;
        line-height: 56px;
        display: flex;
        text-align: center;
        align-items: center;
        justify-content: center;
        height: 72px;
        text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2); /* Внутрішня тінь */
    }



    .service-item {
        width: 30%; /* Розмір блоку */
        height: 200px;
        margin: 10px;
        padding: 20px;
        text-align: center;
        background-color: var(--yellow-200);
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center; /* Вирівнює іконки та текст по центру по вертикалі */
        gap: 20px; /* Проміжок між іконкою та текстом */
        transition: background-color 0.3s ease, color 0.3s ease; /* Анімація зміни кольору */
    }

    .service-item:hover {
        background-color: var(--yellow-500);
        text-decoration: none;
        transform: scale(1.1);
    }


    .info-section{
        height: 700px; /* Фіксована ширина */
        display: flex; /* Вмикаємо Flexbox */
        flex-direction: column; /* Розташовуємо елементи вертикально */
        justify-content: space-between; /* Рівномірно розподіляємо елементи */
        padding: 40px 20px;
        text-align: center;
    }


    .vector1-icon {
        position: absolute;
        top: 1005px;
        left: 0px;
        width: 651px;
        height: 455px;
        z-index: -1;
    }
    .vector2-icon {
        position: absolute;
        top: 730px;
        left: 963px;
        width: 557px;
        height: 473px;
        z-index: -1;
    }
    .vector3-icon {
        position: absolute;
        top: 1460px;
        left: 0px;
        width: 1520px;
        height: 630px;
        z-index: -1;
    }

    .reasons {
        display: grid; /* Використовуємо CSS Grid */
        grid-template-columns: repeat(2, 1fr); /* Створюємо 2 колонки */
        gap: 20px; /* Відстань між елементами */
    }


    .reason-item {
        width: 40%; /* Розмір блоку */
        height: 200px;
        margin: 10px;
        padding: 20px;
        text-align: left;
        background-color: var(--yellow-500);
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column; /* Розміщення елементів вертикально */
        align-items: center; /* Вирівнює елементи по центру по горизонталі */
        gap: 8px; /* Проміжок між іконкою та текстом */
        transition: background-color 0.3s ease, color 0.3s ease; /* Анімація зміни кольору */
    }

    .reason-item:hover {
        background-color: var(--yellow-400);
        text-decoration: none;
        transform: scale(1.1);
    }
    .reason-item h3 {
        font-size: 26px; /* Розмір шрифту для заголовків h3 */
        color: var(--green-800);
        text-shadow: 0.5px 0 0 var(--green-800), 0 0.5px 0 var(--green-800), -0.5px 0 0 var(--green-800), 0 -0.5px 0 var(--green-800);
    }


    .reason-item p {
        font-weight: bold;
        color:  var(--green-800);
        font-size: 20px; /* Розмір шрифту для параграфів p */

    }


    .why-us-section{
        height: 670px; /* Фіксована ширина */
        display: flex; /* Вмикаємо Flexbox */
        flex-direction: column; /* Розташовуємо елементи вертикально */
        justify-content: space-between; /* Рівномірно розподіляємо елементи */
        padding: 40px 20px;
        text-align: center;
        margin-top: 30px;
    }


    .volunteers-section {
        height: 670px; /* Фіксована ширина */
        display: flex; /* Вмикаємо Flexbox */
        flex-direction: column; /* Розташовуємо елементи вертикально */
        justify-content: space-between; /* Рівномірно розподіляємо елементи */
        padding: 40px 20px;
        text-align: center;
        margin-top: 50px;
    }

    .otziv-parent {
        display: flex;
        flex-direction: row;
        overflow-x: auto;
        gap: 35px;
        padding: 20px;
        background-color:  var(--green-200);
    }

    .otziv {
        width: 400px;
        box-shadow: 2px 8px 16px rgba(194, 198, 208, 0.06);
        border-radius: 5px;
        background-color: var(--yellow-200);
        padding: 30px;
        flex-shrink: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 20px;
        transition: background-color 0.3s ease, color 0.3s ease; /* Анімація зміни кольору */
    }

    .otziv:hover {
        background-color: var(--yellow-500);
        text-decoration: none;
        transform: scale(1.1);
    }

    .img1-icon {
        width: 200px;
        height: 180px;
        border-radius: 1000px;
        object-fit: cover;
    }

    .header2 {
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 20px;
    }

    .header-text, .header-text2 {
        text-align: center;
        font-size: 18px;
        color: #333;
    }

    .text-more {
        width: 100%;
        text-align: center;
    }

    .div21 {
        text-align: center;
        font-size: 16px;
        line-height: 1.5;
        font-weight: 500;
    }

    .b7 {
        font-size: 22px;
        line-height: 30px;
        letter-spacing: 0.05em;
        margin-bottom: 10px;
    }

    .span, .span1 {
        display: block;
        font-size: 16px;
    }

    .info-section, .why-us-section, .volunteers-section {
        padding: 40px 20px;
        text-align: center;
    }

    .services-list, .reasons{
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
    }


    .service-item img, .volunteer-item img {
        width: 50px;
        height: auto;
        margin-bottom: 15px;
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



    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();

            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
</script>
