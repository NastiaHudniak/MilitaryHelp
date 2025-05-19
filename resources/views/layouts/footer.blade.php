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
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/alerts.css') }}">
</head>

<body>
<footer class="footer">
    <div class="left-block" style="width: 340px;">
       <div class="logo-social-block">
           <a  href="#logos">
               <img src="{{ asset('images/logo/logo.svg') }}" alt="Logo">
           </a>
           <div class="social-media">
               <a href="https://www.instagram.com/___aanastaasia___"  style="height: 40px">
                   <img src="{{ asset('images/icon/socialmedia.svg') }}">
               </a>
               <a href="https://www.facebook.com/profile.php?id=100013498512633" style="height: 40px">
                   <img src="{{ asset('images/icon/socialmedia-1.svg') }}">
               </a>
               <a href="https://t.me/nas_tia_a" style="height: 40px">
                   <img src="{{ asset('images/icon/socialmedia-2.svg') }}">
               </a>
               <a href="https://github.com/NastiaHudniak/MilitaryHelp" style="height: 40px">
                   <img src="{{ asset('images/icon/socialmedia-3.svg') }}">
               </a>
           </div>
       </div>
        <div class="text-block">
            <p class="one-text">Розроблено</p>
            <p class="two-text">Hudniak Anastasiia</p>
            <p class="two-text">Military Help</p>
            <p class="one-text">Усі права захищені.2025</p>
        </div>
    </div>
    <div class="right-block" >
        <div class="navigation-block">
            <h5 class="navigation-title">Навігація</h5>

            @guest
                <div class="list-navigation">
                    <a href="#home-section" >Головна</a>
                    <a href="#help-section" >Допомога</a>
                    <a href="#analytics-section" >Аналітика</a>
                    <a href="#about-section" >Про нас</a>
                    <a href="#volunteers-section" >Волонтери</a>
                </div>
            @else
                @if(Auth::user()->role_id == 2)
                    <div class="list-navigation">
                        <a href="{{ route('user.military.create') }}">Створити заявку</a>
                        <a href="{{ route('user.military.view_app') }}">Переглянути всі заявки</a>
                        <a href="{{ route('user.military.vol.view_volunteer') }}">Переглянути волонтерів</a>
                    </div>
                @else
                    <div class="list-navigation">
                        <a href="#help-section">Головна</a>
                        <a href="#about-section">Про нас</a>
                        <a href="#volunteers-section">Волонтери</a>
                    </div>
                @endif
            @endguest
        </div>
        <div class="connection-block" style="width: 300px;">
            <h5 class="connection-title">Зворотній зв'язок</h5>
            <div class="connection-form">
                <input type="text" class="input-message" id="feedbackMessage" placeholder="Введіть ваше повідомлення...">
                <a class="send-button" id="sendFeedback">
                    <img src="{{ asset('images/icon/send.svg') }}" alt="Send">
                </a>
            </div>
            <p class="connection-text">Якщо виникли проблеми, будь ласка, зверніться до нас</p>
        </div>
    </div>
</footer>



<script>
    document.getElementById('sendFeedback').addEventListener('click', function () {
        const messageInput = document.getElementById('feedbackMessage');
        const message = messageInput.value.trim();

        if (!message) {
            showToast('Будь ласка, введіть повідомлення.', 'error');
            return;
        }

        // showLoader(true);
        showLoaderWithDelay();

        fetch("{{ route('feedback.send') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ message })
        })
            .then(res => {
                // showLoader(false);
                hideLoader();
                if (!res.ok) throw new Error('Помилка мережі');
                return res.json();
            })
            .then(data => {
                if (data.success) {
                    showToast('Повідомлення успішно надіслано!', 'success');
                    messageInput.value = '';
                }
                else if(data.error){
                    showToast('Сталася помилка!', 'error');
                    messageInput.value = '';
                }
            })
            .catch(err => {
                showError('Сталася помилка при надсиланні. Спробуйте пізніше.');
                console.error(err);
            });
    });




    window.addEventListener('DOMContentLoaded', () => {
        const successAlert = document.getElementById('success-alert');
        if (successAlert) {
            successAlert.style.display = 'flex';
        }
    });

</script>


<style>

    html{
        scroll-behavior: smooth;
    }
    .footer {
        background-color: var(--green-light);
        padding: 64px 190px;
        display: flex;
        justify-content: space-between;
        flex-direction: row;
    }


    .logo-social-block{
        display: flex;
        justify-content: start;
        flex-direction: row;
        align-items: center;
        gap: 48px;
    }

    .social-media{
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 16px;
        width: 96px;
        height: 96px;
    }

    .text-block{
        display: flex;
        flex-wrap: wrap;
        justify-content: left;
        gap: 8px;
        width: 100%;
    }

    .one-text{
        color: var(--green-dark);
        font-size: 16px;
        font-weight: 400;
        line-height: 24px;
        word-wrap: break-word;
        margin: 0;
    }
    .two-text{
        color: var(--main-white);
        font-size: 16px;
        font-weight: 600;
        line-height: 24px;
        word-wrap: break-word;
        margin: 0;
    }

    .left-block{
        display: flex;
        justify-content: start;
        flex-direction: column;
        align-items: start;
        gap: 16px;
    }

    .right-block{
        display: flex;
        justify-content: start;
        flex-direction: row;
        align-items: start;
        gap: 96px;
    }

    .navigation-block, .connection-block{
        display: flex;
        justify-content: start;
        flex-direction: column;
        align-items: start;
        gap: 32px;
    }

    .navigation-title, .connection-title{
        color: var(--main-white);
        font-size: 24px;
        font-weight: 600;
        line-height: 36px;
        word-wrap: break-word;
        margin: 0;
    }

    .list-navigation{
        text-decoration: none;
        margin: 0;
        display: flex;
        justify-content: start;
        flex-direction: column;
        align-items: start;
        gap: 16px;


    }

    .list-navigation a, .connection-text{
        color: var(--main-white);
        font-size: 18px;
        font-weight: 400;
        line-height: 27px;
        word-wrap: break-word;
    }


    .connection-form {
        width: 100%;
        display: flex;
        align-items: center;
        background-color: var(--main-white);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .input-message {
        flex-grow: 1;
        padding: 8px;
        border: none;
        outline: none;
        font-size: 14px;
        font-weight: 400;
        line-height: 21px;
        word-wrap: break-word;
        color: var(--greey-my);
    }

    .input-message::placeholder {
        color: var(--greey-my);
        transition: color 0.3s ease;
    }

    .input-message:hover::placeholder {
        color: var(--green-dark);
    }

    .send-button {
        background: transparent;
        border: none;
        padding: 12px;
        cursor: pointer;
        transition: transform 0.3s ease;
    }

    .send-button:focus {
        background: transparent;
        border: none;
    }

         /* Для екранів до 1200px */
    @media (max-width: 1200px) {
        .footer {
            padding: 48px 80px;
            gap: 64px;
        }
        .right-block {
            gap: 64px;
        }
    }

    /* Для екранів до 992px (планшети) */
    @media (max-width: 992px) {
        .footer {
            flex-direction: column;
            align-items: center;
            padding: 48px 40px;
            gap: 48px;
        }

        .left-block, .right-block {
            width: 100%;
            align-items: center;
        }

        .logo-social-block {
            flex-direction: column;
            gap: 24px;
        }

        .social-media {
            width: auto;
            height: auto;
            justify-content: center;
        }

        .text-block {
            justify-content: center;
            text-align: center;
        }

        .navigation-block, .connection-block {
            align-items: center;
            text-align: center;
        }

        .list-navigation {
            align-items: center;
        }

        .connection-form {
            max-width: 400px;
        }
    }

    /* Для екранів до 768px (мобільні) */
    @media (max-width: 768px) {
        .footer {
            padding: 32px 24px;
        }

        .right-block {
            flex-direction: column;
            align-items: center;
            gap: 32px;
        }

        .navigation-block, .connection-block {
            width: 100%;
            gap: 24px;
        }

        .connection-form {
            width: 100%;
        }
    }

    /* Для екранів до 576px (маленькі мобільні) */
    @media (max-width: 576px) {
        .input-message {
            font-size: 12px;
            padding: 8px 12px;
        }

        .send-button {
            padding: 8px;
        }

        .navigation-title, .connection-title {
            font-size: 20px;
            line-height: 30px;
        }

        .list-navigation a, .connection-text {
            font-size: 16px;
        }
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
