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



{{--        <div class="title-name">--}}
{{--            <h style=" color: var(--green-800); font-size: 40px; text-shadow: 0.5px 0 0 var(--green-800), 0 0.5px 0 var(--green-800), -0.5px 0 0 var(--green-800), 0 -0.5px 0 var(--green-800);" class="b">Ваш особистий кабінет </h>--}}
{{--            <span class="mr-3" style=" color: var(--green-800); font-size: 40px; "> Вітаємо, {{ $user->login }}!</span>--}}

{{--        </div>--}}
{{--        <div class="row mb-4">--}}
{{--            <div class="infoblock" style="gap: 30px;">--}}
{{--                <div class="info">--}}
{{--                    <div class="title_info">--}}
{{--                        <p style="margin-bottom: 0; color: var(--green-800); font-size: 30px;" >Контактна інформація</p>--}}
{{--                        <a href="{{ route('user.military.edit_account', $user) }}" class="cuida--edit-outline" style="color: var(--green-800); font-size: 35px;"></a>--}}
{{--                    </div>--}}

{{--                    <div class="info-body" style="color: var(--green-500);">--}}
{{--                        <div class="row d-flex " style="width: 100%;  align-items: flex-start; font-size: 25px;">--}}
{{--                            <div class="col-md-4" style="align-items: flex-start;">--}}
{{--                                <p style=" margin-bottom: 0;" class="card-text"><strong style="color: var(--green-800);">Логін:</strong> {{$user->login }}</p>--}}
{{--                                <p style=" margin-bottom: 0;" class="card-text"><strong style="color: var(--green-800);">Прізвище:</strong> {{$user->surname }}</p>--}}
{{--                                <p style=" margin-bottom: 0;" class="card-text"><strong style="color: var(--green-800);">Ім'я:</strong> {{$user->name }}</p>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-5" style="width: 100%;  align-items: flex-start; font-size: 25px;">--}}
{{--                                <p style=" margin-bottom: 0;" class="card-text"><strong style=" margin-bottom: 0; color: var(--green-800);">Електронна пошта:</strong> {{$user->email }}</p>--}}
{{--                                <p style=" margin-bottom: 0;" class="card-text"><strong style="color: var(--green-800);">Телефон:</strong> {{$user->phone }}</p>--}}
{{--                                <p style=" margin-bottom: 0;" class="card-text"><strong style="color: var(--green-800);">Адреса:</strong> {{$user->address }}</p>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-3" style="width: 100%; font-size: 25px; display: flex; flex-direction: column; align-items: flex-end; justify-content: space-between;">--}}
{{--                                @if ($userImage)--}}
{{--                                    @if(str_contains($userImage->image_url,'images/acc.jpg'))--}}
{{--                                        <img src="{{  url('/').'/'.$userImage->image_url }}" alt="User Image" style="width: 100px; height: 100px; border-radius: 50px;">--}}
{{--                                    @else--}}
{{--                                        <img src="{{ asset('storage/' . $userImage->image_url) }}" alt="User Image" style="width: 100px; height: 100px; border-radius: 50px;">--}}
{{--                                    @endif--}}
{{--                                @else--}}
{{--                                    <p>No image available.</p>--}}
{{--                                @endif--}}
{{--                                    <button onclick="window.location.href='{{ route('user.military.account.edit_photo', $user->id) }}'" class="btn btn-outline " style="color: var(--green-500);border-color: var(--green-500);">--}}
{{--                                        Редагувати фото--}}
{{--                                    </button>--}}

{{--                            </div>--}}




{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="info">--}}
{{--                    <div class="title_info">--}}
{{--                        <p style="margin-bottom: 0; color: var(--green-800); font-size: 30px;">Ваші заявки</p>--}}
{{--                        <a id="history-icon" class="solar--history-bold-duotone" style="color: var(--green-800); font-size: 37px; " href="{{ route('user.military.view_app') }}"></a>--}}
{{--                    </div>--}}
{{--                    <div class="info-body" style="color: var(--green-500);">--}}
{{--                        <div class="row d-flex" style="width: 100%; align-items: flex-start; font-size: 25px;">--}}
{{--                            <div class="col-md-6" style="align-items: flex-start;">--}}
{{--                                <p style="margin-bottom: 0;" class="card-text">--}}
{{--                                    <strong style="color: var(--green-800);">Загальна кількість заявок:</strong> {{ $totalApplications }}--}}
{{--                                </p>--}}
{{--                                <p style="margin-bottom: 0;" class="card-text">--}}
{{--                                    <strong style="color: var(--green-800);">Прийняті заявки:</strong> {{ $acceptedApplications }}--}}
{{--                            </div>--}}

{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}




{{--            </div>--}}
{{--        </div>--}}
    </div>

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
</style>
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
</script>
