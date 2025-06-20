@extends('layouts.app')
@include('layouts.header_volunteer')

@section('content')
    <div class="main-content" style="font-family: 'Open Sans', sans-serif;">
        <div class="block-info">
           <div class="profile-card">
                <div class="profile-info">
                    <div class="profile-photo">
                        @if ($userImage)
                                @if(str_contains($userImage->image_url,'images/acc.jpg'))
                                    <img  src="{{ url('/') . '/' . $userImage->image_url }}" alt="User Image">
                                @else
                                    <img  src="{{ asset('storage/' . $userImage->image_url) }}" alt="User Image">
                                @endif
                        @else
                            <p>No image available.</p>
                        @endif
                    </div>
                    <p class="profile-info-title">
                        {{ $millitary->surname }} {{ $millitary->name }}!
                    </p>


                </div>
               <div class="profile-info-subtitle">
                   <p>{{ $millitary->email }}</p>
                   <p>{{ $millitary->phone }}</p>
                   <p>{{ $millitary->address }}</p>
               </div>
            </div>
           <div class="application-block" id="application-card-container">
                @foreach ($applications as $application)
                    <div class="card-application">
                        <div class="card-foto">
                            <div class="image-scroll-container" style="overflow-x: auto; white-space: nowrap; margin: 0">
                                @if($application->images->isEmpty())
                                    <!-- Заглушка: картинка або текст -->
                                    <div class="no-image-placeholder" style="height: 130px; width: 100%; display: flex; justify-content: center; align-items: center; background: var(--yellow-my); color: var(--green-dark); font-size: 16px; border-radius: 8px;">
                                        Зображень немає
                                    </div>
                                    {{-- або замість тексту можете вставити зображення заглушки: --}}
                                    {{-- <img src="{{ asset('images/no-image.png') }}" alt="Зображень немає" style="max-height: 130px; object-fit: contain;"> --}}
                                @else
                                    @foreach ($application->images as $image)
                                        <img src="{{ asset('storage/' . $image->image_url) }}" alt="Зображення заявки" class="img-fluid" style="max-height: 130px; object-fit: cover; display: inline-block">
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="card-header-app">
                            <h5 class="card-title-app">{{ $application->title }}
                                @if($application->is_urgent)
                                    <span class="term">Термінова</span>
                                @endif
                            </h5>
                            <h6 class="card-subtitle-app">{{ $application->category->name }}</h6>
                        </div>
                        <div class="buttons-blocks">
                            <a href="javascript:void(0);" class="button-view-info" data-toggle="modal" data-target="#applicationModal{{ $application->id }}">
                                Детальніше
                                <img src="{{ asset('images/icon/info.svg') }}">
                            </a>

                            <div class="card-buttons">
                                {{--                @php--}}
                                {{--                    $isLiked = in_array($application->id, $userLikedApplicationIds);--}}
                                {{--                @endphp--}}
                                {{--                <button class="like-btn" type="button" data-id="{{ $application->id }}">--}}
                                {{--                    <img src="{{ $isLiked ? asset('images/icon/likes/like-filled.svg') : asset('images/icon/likes/like.svg') }}"--}}
                                {{--                         alt="Like"--}}
                                {{--                         class="like-icon"--}}
                                {{--                         data-outline="{{ asset('images/icon/likes/like.svg') }}"--}}
                                {{--                         data-filled="{{ asset('images/icon/likes/like-filled.svg') }}">--}}
                                {{--                </button>--}}
                                @php
                                    $isConfirmedByThisVolunteer = $application->volunteer_id === auth()->id();
                                @endphp
                                @if($isConfirmedByThisVolunteer)
                                    <a href="{{ route('user.volunteer.confirm.edit_confirm_app', $application->id) }}" class="button-reports" type="button" >
                                        <img src="{{ asset('images/icon/edit.svg') }}" alt="Редагувати">

                                    </a>
                                @else
                                    <a href="{{ route('user.volunteer.confirm_application', ['id' => $application->id]) }}" class="button-reports" type="button">
                                        <img src="{{ asset('images/icon/znak.svg') }}" alt="Підтвердити">

                                    </a>
                                @endif

                            </div>
                        </div>
                    </div>

                    <div class="modal" id="applicationModal{{ $application->id }}" tabindex="-1" aria-labelledby="applicationModalLabel{{ $application->id }}" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" style="top: 10%; left: 30%;">
                        <div class="modal-info-block">
                            <div class="modal-status-close">
                                <p class="info-status
                    @if ($application->status === 'створено') status-created
                    @elseif ($application->status === 'прийнято') status-accepted
                    @elseif ($application->status === 'відхилено') status-rejected
                    @endif">
                                    {{ $application->status }}
                                </p>
                                <button type="button" class="close-button" data-bs-dismiss="modal" aria-label="Close">
                                    <img src="{{ asset('images/icon/cancell.svg') }}">
                                </button>
                            </div>

                            <div class="modal-text">
                                <div class="modal-title">
                                    <p class="info-title">{{ $application->title }}</p>
                                    <p class="info-category">{{ $application->category->name }}</p>
                                </div>
                                <div class="modal-description">
                                    <p class="info-description">{{ $application->description }}
                                    <p class="info-description"> Заявку створив:{{ $application->millitary->name }} {{ $application->millitary->surname }}</p>
                                </div>

                            </div>

                            <div class="modal-foto">
                                <div class="image-scroll-container" style="overflow-x: auto; white-space: nowrap; margin: 0">
                                    @foreach ($application->images as $image)
                                        <img src="{{ asset('storage/' . $image->image_url) }}" alt="Зображення заявки" class="img-fluid" style="max-height: 130px; object-fit: cover; display: inline-block">
                                    @endforeach
                                </div>
                            </div>


                            <div class="modal-footer">
                                <a href="{{ route('user.military.pdf', $application->id) }}" class="button-report" type="button">
                                    <img src="{{ asset('images/icon/pdf.svg') }}">
                                    Сформувати .pdf
                                </a>
                                <div class="card-buttons-f">
                                    {{--                    @php--}}
                                    {{--                        $isLiked = in_array($application->id, $userLikedApplicationIds);--}}
                                    {{--                    @endphp--}}
                                    {{--                    <button class="like-btn" type="button" data-id="{{ $application->id }}">--}}
                                    {{--                        <img src="{{ $isLiked ? asset('images/icon/likes/like-filled.svg') : asset('images/icon/likes/like.svg') }}"--}}
                                    {{--                             alt="Like"--}}
                                    {{--                             class="like-icon"--}}
                                    {{--                             data-outline="{{ asset('images/icon/likes/like.svg') }}"--}}
                                    {{--                             data-filled="{{ asset('images/icon/likes/like-filled.svg') }}">--}}
                                    {{--                    </button>--}}
                                </div>
                            </div>
                        </div>
                    </div>


                @endforeach
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

    .block-info{
        display: flex;
        justify-content: space-between;
        flex-direction: row;
        align-items: start;
        text-align: start;
        gap: 44px;

        padding: 64px 80px;
    }


      .profile-card {
        display: flex;
        justify-content: center;
        align-items: start;
        flex-direction: column;
        gap: 32px;
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
        width: 180px;
        height: 180px;
        object-fit: cover;
        border-radius: 50%;
    }

    .profile-info{
        display: flex;
        flex-direction: row;
        align-items: start;
        text-align: left;
        gap: 24px;
    }

    .profile-info-title{
        margin: 0;
        color: var(--orange-my) !important;
        font-size: 32px;
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


    .application-block{
        width: 100%;
        display: flex;
        flex-wrap: wrap;
        justify-content: start;
        gap: 36px;
        padding: 0;
    }

    @media (max-width: 768px) {

        .application-block{
            gap: 12px;
            padding: 24px;
        }
    }






    .card-application{
        width: calc(33% - 27px);
        display: flex;
        justify-content: flex-end;
        align-items: flex-start;
        flex-direction: column;
        padding: 16px;
        gap: 24px;
        background-color: var(--yellow-my);
        border-radius: 16px;
    }

    .card-foto{
        padding: 0;
    }

    .card-header-app{
        display: flex;
        justify-content: flex-start;
        align-items: flex-start;
        flex-direction: column;
        gap: 0;
        background-color: transparent; !important;
        border: none; !important;

    }

    .term{
        border-radius: 16px;
        font-size: 14px;
        font-weight: 600;
        line-height: 130%;
        background-color: var(--red-100);
        color: var(--red-100-15);
        padding: 4px 8px;
    }
    .card-title-app {
        color: var(--black-my);
        font-size: 20px;
        font-weight: 600;
        line-height: 130%;
        word-wrap: break-word;
        margin: 0;
    }

    .card-subtitle-app{
        color: var(--main-green-dark);
        font-size: 16px;
        font-weight: 400;
        line-height: 130%;
        word-wrap: break-word;
        margin: 0;
    }

    .image-scroll-container::-webkit-scrollbar {
        height: 8px;
    }

    .image-scroll-container::-webkit-scrollbar-track {
        background: var(--green-light);
    }

    .image-scroll-container::-webkit-scrollbar-thumb {
        background: var(--orange-my);
        border-radius: 10px;
    }

    .image-scroll-container::-webkit-scrollbar-thumb:hover {
        background: var(--orange-my);
    }
    .image-scroll-container img {
        height: 130px;
        width: auto;
        object-fit: cover;
        display: inline-block;
    }

    .like-btn, .button-report {
        background: none;
        border: none;
        padding: 0;
        margin: 0;
        outline: none;
        cursor: pointer;
        appearance: none;
    }

    .like-btn:focus,
    .like-btn:active {
        outline: none;
        box-shadow: none;
    }

    .like-icon {
        width: 24px;
        height: 24px;
        display: block;
    }


    .buttons-blocks{
        width: 100%;
        display: flex;
        justify-content: space-between;
        padding: 0;
        background-color: transparent;
        border: none;
    }

    .button-view-info{
        display: flex;
        align-items: center;
        justify-content: center;
        width: auto;
        height: fit-content;
        background-color: var(--yellow-my);
        border-radius: 16px;
        border: 1px var(--main-green-dark) solid;
        color: var(--main-green-dark);
        gap: 8px;
        font-size: 14px;
        font-weight: 500;
        line-height: 130%;
        padding: 6px 16px;
        text-align: center;
        cursor: pointer;
        text-decoration: none;
        transition: background-color 0.5s ease, color 0.5s ease;
    }

    .card-buttons{
        display: flex;
        align-items: center;
        flex-direction: row;
        padding: 0;
        gap: 16px;
    }

    .button-actions{
        text-decoration: none;
        border: none;
        background-color: transparent;
        padding: 0;
    }


    .modal-info-block{
        width: 40%;
        display: flex;
        justify-content: start;
        flex-direction: column;
        gap: 24px;
        border-radius: 16px;
        padding: 24px;
        background-color: var(--main-white);
    }


    .modal-status-close{
        display: flex;
        justify-content: space-between;
        flex-direction: row;
        padding: 0;
        margin: 0;

    }

    .info-status {
        display: flex;
        padding: 4px 16px;
        margin: 0 !important;
        border-radius: 16px;
        font-size: 14px;
        font-weight: 400;
        line-height: 130%;
        border: 1px solid;
    }

    .status-created {
        border-color: var(--green-100);
        background-color: var(--green-15);
        color: var(--green-100);
    }

    .status-accepted {
        border-color: var(--blue-100);
        background-color: var(--blue-15);
        color: var(--blue-100);
    }

    .status-rejected {
        border-color: var(--red-100);
        background-color: var(--red-15);
        color: var(--red-100);
    }


    .close-button{
        padding: 0;
        margin: 0;
        background-color: transparent;
        border: none;
    }

    .modal-text{
        display: flex;
        justify-content: start;
        flex-direction: column;
        gap: 12px;
    }

    .modal-title, .modal-description{
        display: flex;
        justify-content: start;
        flex-direction: column;
        gap: 0;

    }

    .info-title{
        color: var(--black-my);
        font-size: 20px;
        font-weight: 600;
        line-height: 130%;
        word-wrap: break-word;
        margin: 0;
    }

    .info-category{
        color: var(--greey-my);
        font-size: 16px;
        font-weight: 400;
        line-height: 130%;
        word-wrap: break-word;
        margin: 0;
    }

    .info-description{
        color: var(--green-dark);
        font-size: 16px;
        font-weight: 400;
        line-height: 130%;
        word-wrap: break-word;
        margin: 0;
    }

    .modal-foto{
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-direction: row;
        gap: 16px;
    }

    .navigation-modal-photo{
        height: fit-content;
        display: flex;
        justify-content: center;
        padding: 8px 4px;
        flex-direction: column;
        gap: 16px;
        border-radius: 16px;
        background-color: var(--yellow-my);
    }

    .modal-footer{
        width: 100%;
        display: flex;
        align-items: start;
        justify-content: start;
        flex-direction: row;
        gap: 16px;
    }
    .card-buttons-f{
        display: flex;
        align-items: center;
        flex-direction: row;
        padding: 0;
        gap: 16px;
    }

    .modal-text-volunteers{
        display: flex;
        justify-content: start;
        flex-direction: column;
        gap: 0;
    }

    .info-vol{
        color: var(--orange-my);
        font-size: 16px;
        font-weight: 400;
        line-height: 130%;
        word-wrap: break-word;
        margin: 0;
    }


    @media (max-width: 768px) {

        .block-info{
            flex-direction: column;
            gap: 24px;
            padding: 24px;
            align-items: center;
        }


        .profile-card {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            gap: 16px;
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
            width: 120px;
            height: 120px;
        }

        .profile-info{
            align-items: center;
            flex-direction: column;
            gap: 4px;
        }

        .profile-info-title{
            margin: 0;
            color: var(--orange-my) !important;
            font-size: 20px;
            font-weight: 600;
        }

        .profile-info-subtitle{
            flex-direction: column;
            align-items: center;
            gap: 4px;
        }

        .profile-info-subtitle p{
            font-size: 16px;
            text-align: center;
        }


        .application-block{
            gap: 12px;
            padding: 0;
        }

        .card-application{
            width: calc(50% - 12px);
            gap: 12px;
        }

        .card-title-app {
            font-size: 16px;
        }

        .card-subtitle-app{
            font-size: 12px;
        }

        .image-scroll-container::-webkit-scrollbar {
            height: 4px;
        }

        .image-scroll-container img {
            height: 100px;
        }

        .like-count{
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 1px;
        }

        .buttons-blocks{
            display: flex;
            flex-direction: column;
            align-items: start;
            gap: 8px;
        }


        .card-buttons{
            width: 100%;
            justify-content: space-between;
        }



        .modal {
            top: 5% !important;
            left: 5% !important;
            right: 5% !important;
            width: 90% !important;
            margin: 0 auto;
            padding: 0;
        }

        .modal-info-block {
            width: 100% !important;
            max-height: 90vh;
            overflow-y: auto;
            padding: 16px;
            box-sizing: border-box;
        }



        .modal-status-close{
            display: flex;
            justify-content: space-between;
            flex-direction: row;
            padding: 0;
            margin: 0;

        }

        .modal-text{
            display: flex;
            justify-content: start;
            flex-direction: column;
            gap: 12px;
        }

        .modal-title, .modal-description{
            display: flex;
            justify-content: start;
            flex-direction: column;
            gap: 0;

        }

        .info-title{
            font-size: 18px;
        }

        .info-category{
            font-size: 14px;
        }

        .info-description{
            font-size: 14px;
        }


        .modal-footer{
            width: 100%;
            display: flex;
            align-items: start;
            justify-content: space-between !important;
            flex-direction: row;
            gap: 16px;
        }

        .card-buttons-f{
            gap: 12px;
        }


        .info-vol{
            font-size: 14px;
        }
    }


</style>
