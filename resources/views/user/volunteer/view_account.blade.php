@extends('layouts.app')
@include('layouts.header_volunteer')

@section('content')

    <div class="container" style="max-width: 1300px; padding: 50px 0px;">
        <div class="title-name">
            <h style=" color: var(--green-800); font-size: 40px; text-shadow: 0.5px 0 0 var(--green-800), 0 0.5px 0 var(--green-800), -0.5px 0 0 var(--green-800), 0 -0.5px 0 var(--green-800);" class="b">Ваш особистий кабінет </h>
            <span class="mr-3" style=" color: var(--green-800); font-size: 40px; "> Вітаємо, {{ $user->login }}!</span>

        </div>
        <div class="row mb-4">
            <div class="infoblock" style="gap: 30px;">
                <div class="info">
                    <div class="title_info">
                        <p style="margin-bottom: 0; color: var(--green-800); font-size: 30px;" >Контактна інформація</p>
                        <a href="{{ route('user.volunteer.edit_account', $user) }}" class="cuida--edit-outline" style="color: var(--green-800); font-size: 35px;"></a>
                    </div>

                    <div class="info-body" style="color: var(--green-500);">
                        <div class="row d-flex " style="width: 100%;  align-items: flex-start; font-size: 25px;">
                            <div class="col-md-6" style="align-items: flex-start;">
                                <p style=" margin-bottom: 0;" class="card-text"><strong style="color: var(--green-800);">Логін:</strong> {{$user->login }}</p>
                                <p style=" margin-bottom: 0;" class="card-text"><strong style="color: var(--green-800);">Прізвище:</strong> {{$user->surname }}</p>
                                <p style=" margin-bottom: 0;" class="card-text"><strong style="color: var(--green-800);">Ім'я:</strong> {{$user->name }}</p>
                            </div>
                            <div class="col-md-6" style="width: 100%;  align-items: flex-start; font-size: 25px;">
                                <p style=" margin-bottom: 0;" class="card-text"><strong style=" margin-bottom: 0; color: var(--green-800);">Електронна пошта:</strong> {{$user->email }}</p>
                                <p style=" margin-bottom: 0;" class="card-text"><strong style="color: var(--green-800);">Телефон:</strong> {{$user->phone }}</p>
                                <p style=" margin-bottom: 0;" class="card-text"><strong style="color: var(--green-800);">Адреса:</strong> {{$user->address }}</p>
                            </div>
                        </div>
                    </div>
                </div>

{{--                <div class="info">--}}
{{--                    <div class="title_info">--}}
{{--                        <p style="margin-bottom: 0; color: var(--green-800); font-size: 30px;">Ваші заявки</p>--}}
{{--                        <span class="cuida--edit-outline" style="color: var(--green-800); font-size: 35px;"></span>--}}
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




            </div>
        </div>
    </div>

@endsection

<style>

    .title-name{
        display: flex;
        flex-direction: column;
        justify-content: space-between;

    }

    .infoblock{
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 20px; /* Проміжок між іконкою та текстом */

    }

    .info {
        width: 100%; /* Розмір блоку */
        padding: 20px;
        text-align: center;
        background-color: var(--yellow-200);
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
        align-items: flex-start; /* Вирівнює іконки та текст по центру по вертикалі */
        gap: 20px; /* Проміжок між іконкою та текстом */
        transition: background-color 0.3s ease, color 0.3s ease; /* Анімація зміни кольору */
    }

    .info-body {

        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }
    .title_info {
        width: 100%;
        display: flex;
        flex-direction: row;
        align-items: flex-start;
        justify-content: space-between;
    }

    .card-text{
        text-align: left;
    }
</style>
