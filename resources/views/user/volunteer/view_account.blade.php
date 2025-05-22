@extends('layouts.app')
@include('layouts.header_volunteer')

@section('content')

    <div class="main-content" style="font-family: 'Open Sans', sans-serif;">
        <div class="main-info">
            @include('components.sidebar_account', ['user' => $user])

            <div class="profile-cards">
                <div class="profile-card">
                    <div class="profile-photo">
                        @if ($userImage)
                            @if(str_contains($userImage->image_url,'images/acc.jpg'))
                                <img src="{{  url('/').'/'.$userImage->image_url }}" alt="User Image">
                            @else
                                <img src="{{ asset('storage/' . $userImage->image_url) }}" alt="User Image">
                            @endif
                        @else
                            <p>No image available.</p>
                        @endif

                        <a href="{{ route('user.volunteer.account.edit_photo', $user->id) }}" class="edit-photo">Редагувати фото</a>
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
                <div class="profile-card">
                    @if($averageRating !== null)
                        <div class="rate-block">
                            <p class="rate-title">
                                Ваш середній рейтинг: {{ number_format($averageRating, 1) }}
                            </p>
                            <div class="rate-body">
                                @for($i = 1; $i <= 5; $i++)
                                    <div class="star">
                                        @if($averageRating >= $i)
                                            <!-- Повністю заповнена зірочка -->
                                            <div class="full"></div>
                                        @elseif($averageRating >= $i - 0.5 && $averageRating < $i)
                                            <!-- Половинно заповнена зірочка -->
                                            <div class="half"></div>
                                        @else
                                            <!-- Порожня зірочка -->
                                            <div class="empty"></div>
                                        @endif
                                    </div>
                                @endfor
                            </div>
                        </div>
                    @else
                        <div class="row mb-4">
                            <div class="infoblock" style="gap: 30px;">
                                <div class="info">
                                    <div class="title_info">
                                        <p style="margin-bottom: 0; color: var(--green-800); font-size: 30px;">Ваш середній рейтинг</p>
                                    </div>
                                    <div class="info-body" style="color: var(--green-500);">
                                        <p style="font-size: 25px;">Рейтинг ще не встановлено.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>
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





    .rate-block {
        width: 100%;
        text-align: center;
        border-radius: 16px;
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 64px;
        padding-top: 16px;
    }

    .rate-title{
        margin: 0;
        color: var(--orange-my) !important;
        font-size: 32px;
        font-weight: 600;
        white-space: nowrap;
    }

    .rate-body {
        width: 100%;
        display: flex;
        flex-direction: row;
        align-items: flex-start;
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

        .rate-block {
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
        }

        .rate-title{
            font-size: 20px;
        }


    }





    .star {
        display: inline-block;
        width: 30px;
        height: 30px;
        margin-right: 5px;
        position: relative;
        background: transparent;
    }

    .star .full {
        border: 2px solid var(--orange-my);
        background-color: var(--orange-my);
        width: 100%;
        height: 100%;
        clip-path: polygon(50% 0%, 61% 35%, 98% 35%, 68% 57%, 79% 91%, 50% 70%, 21% 91%, 32% 57%, 2% 35%, 39% 35%);
        border-radius: 4px;
        box-shadow: 0 0 0 2px var(--orange-my);
    }

    .star .half {
        border: 2px solid var(--orange-my);
        background: linear-gradient(90deg, var(--orange-my) 50%, var(--blue-my) 50%);
        width: 100%;
        height: 100%;
        clip-path: polygon(50% 0%, 61% 35%, 98% 35%, 68% 57%, 79% 91%, 50% 70%, 21% 91%, 32% 57%, 2% 35%, 39% 35%);
        border-radius: 4px;
        box-shadow: 0 0 0 2px var(--orange-my);
    }

    .star .empty {
        background-color: var(--blue-my);
        border: 2px solid var(--orange-my);
        width: 100%;
        height: 100%;
        clip-path: polygon(50% 0%, 61% 35%, 98% 35%, 68% 57%, 79% 91%, 50% 70%, 21% 91%, 32% 57%, 2% 35%, 39% 35%);
        border-radius: 4px;
        box-shadow: 0 0 0 2px var(--orange-my);
    }






</style>
