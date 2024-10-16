@extends('layouts.app')
@include('layouts.header_military')
@section('content')
    <img class="background-icon" src="{{ asset('images/лендінг/background1.png') }}" alt="Background">
    <div class="main-content" style="font-family: 'Jura', sans-serif;">
        <div class="title-parent">
            <div class="title">
                <b style=" color: #e3eee0;" class="b">КОСМЕТОЛОГІЧНА </b>
                <b style=" color: #8fbc82;;" class="b1">ДОПОМОГА</b>
                <b style=" color: #e3eee0;" class="b2">ВІЙСЬКОВИМ</b>
            </div>
            <div class="b3">Солідарність у боротьбі: ваша підтримка — наша сила.</div>
            <a class="learn-more-button" href="{{ url('/login') }}"> Дізнатись більше </a>
        </div>
        <img class="vector1-icon" alt="" src="{{ asset('images/лендінг/vector1.svg') }}">
        <img class="vector2-icon" alt="" src="{{ asset('images/лендінг/vector2.svg') }}">
        <div class="info-section">
            <div class="info-title">
                ВІЙСЬКОВІ ПУБЛІКУЮТЬ ЗАЯВКИ ЗІ СВОЇМИ ПОТРЕБАМИ -
                <span class="highlight">ВОЛОНТЕРИ ДОПОМАГАЮТЬ</span>
            </div>
            <div style="color: #8fbc82"  class="service-title"> Що ми можемо надати? </div>
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
        <div class="why-us-section">
            <div style="color: #f5f786"  class="reasons-title"> Чому саме ми? </div>
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

        <div class="volunteers-section">
            <div style="color: #8fbc82" class="volunteers-title"> Що ми можемо надати? </div>
            <div class="otziv-parent">
                <div class="otziv">
                    <div class="img-text">
                        <img class="img1-icon" alt="" src="{{ asset('images/лендінг/img1.png') }}" />
                        <div class="header2">
                            <b class="b7">Віктор Сергієнко</b>
                        </div>
                    </div>
                    <div class="header-text">
                        <div class="text-more">
                            <div class="div21">
                    <span>
                        <b>Координатор волонтерських ініціатив</b>
                        <span class="span">. Відповідає за організацію зборів гуманітарної допомоги, логістику та доставку на передову.</span>
                    </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="otziv">
                    <div class="img-text">
                        <img class="img1-icon" alt="" src="{{ asset('images/лендінг/img2.png') }}" />
                        <div class="header2">
                            <b class="b7">Ірина Черненко</b>
                        </div>
                    </div>
                    <div class="header-text">
                        <div class="text-more">
                            <div class="div21">
                    <span>
                        <b>Психолог</b>
                        <span class="span1">. Надає психологічну підтримку військовим та їхнім родинам. Проводить консультації, допомагає адаптуватися до мирного життя після фронту.</span>
                    </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="otziv">
                    <div class="img-text">
                        <img class="img1-icon" alt="" src="{{ asset('images/лендінг/img3.png') }}" />
                        <div class="header2">
                            <b class="b7">Василь Нікітенко</b>
                        </div>
                    </div>
                    <div class="header-text">
                        <div class="text-more">
                            <div class="div21">
                    <span>
                        <b>Волонтер</b>
                        <span class="span"> на складі. Відповідає за прийом, сортування та пакування гуманітарних вантажів. Також допомагає у координації доставки медикаментів і військового спорядження.</span>
                    </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="otziv">
                    <div class="img-text">
                        <img class="img1-icon" alt="" src="{{ asset('images/лендінг/img2.png') }}" />
                        <div class="header2">
                            <b class="b7">Наталя Макогончук</b>
                        </div>
                    </div>
                    <div class="header-text">
                        <div class="text-more">
                            <div class="div21">
                    <span>
                        <b>Волонтерка з питань комунікацій</b>
                        <span class="span">. Займається залученням спонсорів, веде соціальні мережі центру, організовує благодійні заходи для збору коштів.</span>
                    </span>
                            </div>
                        </div>
                    </div>
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
        font-family: 'Arial', sans-serif;
        color: #333;
        margin: 0; /* Відмінити відступи з боків */
        max-width: 1400px; /* Встановіть максимальну ширину */
        margin: 0 auto; /* Центруйте контейнер */
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
        margin-bottom: 95px;
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
        color: #fafbc9;
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
        background-color: #f8f9ab;
        color: #2b4324;
        text-align: center;
        font-weight: 500;
        font-size: 24px;
        /*cursor: pointer; /* Курсор у вигляді руки при наведенні */
        /*text-decoration: none; /* Без підкреслення */
        /*line-height: 36px; /* Вирівнює текст по вертикалі */
    }

    .info-title {
        width: 1000px;
        font-weight: 600;
        text-align: center;
        font-size: 60px;
        color: #2b4324;
        flex-shrink: 0;
        margin: 0 auto;
        line-height: 1.2;
        position: relative;
    }
    .highlight {
        background-color: #f8f9ab;
        color: #2b4324;
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
        background-color: #fafbc9;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center; /* Вирівнює іконки та текст по центру по вертикалі */
        gap: 20px; /* Проміжок між іконкою та текстом */
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
        background-color: #f5f786;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column; /* Розміщення елементів вертикально */
        align-items: center; /* Вирівнює елементи по центру по горизонталі */
        gap: 8px; /* Проміжок між іконкою та текстом */
    }
    .reason-item h3 {
        font-size: 26px; /* Розмір шрифту для заголовків h3 */
        color: #2b4324;
        text-shadow: 0.5px 0 0 #2b4324, 0 0.5px 0 #2b4324, -0.5px 0 0 #2b4324, 0 -0.5px 0 #2b4324;
    }


    .reason-item p {
        font-weight: bold;
        color: #2b4324;
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


    .volunteers-section{
        height: 670px; /* Фіксована ширина */
        display: flex; /* Вмикаємо Flexbox */
        flex-direction: column; /* Розташовуємо елементи вертикально */
        justify-content: space-between; /* Рівномірно розподіляємо елементи */
        padding: 40px 20px;
        text-align: center;
        margin-top: 30px;
    }





    .otziv-parent {
        display: flex;
        flex-direction: row;
        overflow-x: auto;
        gap: 20px;
        padding: 20px;
        background-color: #E3EEE0;
    }

    .otziv {
        width: 400px;
        box-shadow: 2px 8px 16px rgba(194, 198, 208, 0.06);
        border-radius: 5px;
        background-color: #fafbc9;
        padding: 20px;
        flex-shrink: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 20px;
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

    .services-list, .reasons, .volunteers {
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
    }


    .service-item img, .volunteer-item img {
        width: 50px;
        height: auto;
        margin-bottom: 15px;
    }

    .volunteer-info {
        margin-top: 10px;
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
