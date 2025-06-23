@extends('layouts.app')
@include('layouts.header_military')

@section('content')

    <div class="main-content" style="font-family: 'Open Sans', sans-serif;">
        <div class="main-info">
            @include('components.sidebar_account', ['user' => $user])

            <div class="profile-card">
                <div class="profile-photo">
                    @if ($userImage)
                        <div class="zoom-container">
                            @if(str_contains($userImage->image_url,'images/acc.jpg'))
                                <img id="zoom-image" src="{{ url('/') . '/' . $userImage->image_url }}" alt="User Image">
                            @else
                                <img id="zoom-image" src="{{ asset('storage/' . $userImage->image_url) }}" alt="User Image">
                            @endif
                            <div id="zoom-lens"></div>
                        </div>
                    @else
                        <p>No image available.</p>
                    @endif

                    <a href="{{ route('user.military.account.edit_photo', $user->id) }}" class="edit-photo">Редагувати фото</a>
                </div>
                <div class="profile-info">
                    <p class="profile-info-title">
                        Вітаємо, {{ $user->surname }} {{ $user->name }}!
                    </p>
                    <div class="profile-info-subtitle">
                        <p>{{ $user->email }}</p>
                        <p>{{ $user->phone }}</p>
                        <p>{{ $user->address }}</p>
                    </div>
                </div>
            </div>

        </div>

        <section class="block-three" id="analytics-section" >
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
            </div>
        </section>
    </div>

    @include('layouts.footer')
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const img = document.getElementById("zoom-image");
        const lens = document.getElementById("zoom-lens");

        if (!img || !lens) return;

        // Дочекаємось завантаження зображення
        img.onload = function () {
            const zoomFactor = 3; // кратність збільшення

            lens.style.backgroundImage = `url('${img.src}')`;
            lens.style.backgroundRepeat = "no-repeat";
            lens.style.backgroundSize = `${img.width * zoomFactor}px ${img.height * zoomFactor}px`;


            const moveLens = (e) => {
                const rect = img.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;

                const lensWidth = lens.offsetWidth / 2;
                const lensHeight = lens.offsetHeight / 2;

                let left = x - lensWidth;
                let top = y - lensHeight;

                // обмеження в межах зображення
                left = Math.max(0, Math.min(left, img.width - lens.offsetWidth));
                top = Math.max(0, Math.min(top, img.height - lens.offsetHeight));

                lens.style.left = `${left}px`;
                lens.style.top = `${top}px`;

                lens.style.backgroundPosition = `-${x * zoomFactor - lensWidth}px -${y * zoomFactor - lensHeight}px`;
            };

            img.addEventListener("mousemove", moveLens);
            lens.addEventListener("mousemove", moveLens);
            img.addEventListener("mouseenter", () => lens.style.display = "block");
            img.addEventListener("mouseleave", () => lens.style.display = "none");
        };
    });


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

    .main-info{
        display: flex;
        justify-content: left;
        flex-direction: row;
        align-items: center;
        padding: 64px 80px;
        gap: 80px;
    }



    .profile-card {
        display: flex;
        justify-content: center;
        align-items: start;
        gap: 64px;
        border-radius: 16px;
    }

    .profile-photo {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 8px;
    }

    .profile-photo img {
        width: 200px;
        height: 200px;
        object-fit: cover;
        border-radius: 50%;
    }

    .edit-photo {
        color: var(--main-green-dark);
        font-size: 16px;
    }

    .edit-photo:hover {
        color: var(--green-light);
    }

    .profile-info{
        display: flex;
        flex-direction: column;
        align-items: start;
        text-align: left;
        gap: 24px;
    }

    .profile-info-title{
        margin: 0;
        color: var(--orange-my) !important;
        font-size: 44px;
        font-weight: 600;
    }

    .profile-info-subtitle{
        display: flex;
        flex-direction: column;
        align-items: start;
        text-align: left;
        gap: 8px;
    }

    .profile-info-subtitle p{
        margin: 0;
        color: var(--green-dark) !important;
        font-size: 22px;
        font-weight: 400;
        line-height: 130%;
    }


    @media (max-width: 768px) {

        .main-info{
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;
            padding: 24px;
            gap: 40px;
        }

        .profile-card {
            flex-direction: row;
            align-items: center;
            gap: 24px;
            border-radius: 16px;
        }

        .profile-photo {
            gap: 2px;
        }
        .profile-photo img {
            width: 80px;
            height: 80px;
        }

        .edit-photo {
            font-size: 14px;
        }

        .edit-photo:hover {
            color: var(--green-light);
        }

        .profile-info{
            gap: 16px;
        }

        .profile-info-title{
            font-size: 22px;
        }

        .profile-info-subtitle{
            gap: 6px;
        }

        .profile-info-subtitle p{
            font-size: 16px;
        }

    }

    .zoom-container {
        position: relative;
        display: inline-block;
    }

    #zoom-image {
        width: 100%;
        max-width: 200px;
        height: 200px;
        display: block;
    }

    #zoom-lens {
        display: none;
        position: absolute;
        border: 2px solid #000;
        width: 100px;
        height: 100px;
        background-repeat: no-repeat;
        pointer-events: none;
        border-radius: 50%;
        box-shadow: 0 0 10px rgba(0,0,0,0.3);
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
        gap: 116px;
        padding: 0px 64px;
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
</style>
