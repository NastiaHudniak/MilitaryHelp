@extends('layouts.app')
@include('layouts.header_volunteer')

@section('content')
    <div class="container" style="max-width: 1300px; padding: 40px 0px;">
        <div class="block-info">
            <div class="block-infos">
                <div class="profile-card">
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
                    <div class="profile-info">
                        <p class="profile-info-title">
                            {{ $millitary->surname }} {{ $millitary->name }}!
                        </p><div class="profile-info-subtitle">
                            <p>{{ $millitary->email }}</p>
                            <p>{{ $millitary->phone }}</p>
                            <p>{{ $millitary->address }}</p>
                        </div>
                    </div>
                </div>
                <div class="buttons-blocks">
                    <form action="{{ route('user.volunteer.confirm_application.confirm', $application->id) }}" method="POST" style="width: 100%; display: flex;  flex-direction: column;" >
                        @csrf
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" class="form-input" name="comment" id="comment" value="{{ $application->comment === 'немає' ? '' : $application->comment }}"placeholder="Введіть коментар">
                            </div>
                            @error('comment')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-buttons" style="margin-top: 1rem;">
                            <button type="submit" class="create-button">Підтаердити заявку</button>
                            <div class="label-create">
                                <p>Не хочете редагувати заявку? </p>
                                <a href="{{ route('user.volunteer.mil.view_military') }}">Назад</a>
                            </div>
                        </div>


                    </form>
                </div>
            </div>

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
                <div class="modal-description">
                    <p class="info-description">{{ $application->description }}
                    <p class="info-description"> Заявку створив:{{ $application->millitary->name }} {{ $application->millitary->surname }}</p>
                </div>
            </div>

        </div>


    </div>
    @include('layouts.footer')
@endsection


<style>
    .block-info{
        display: flex;
        justify-content: space-between;
        flex-direction: row;
        align-items: start;
        text-align: start;
        gap: 44px;
    }

    .block-infos{
        display: flex;
        justify-content: space-between;
        flex-direction: column;
        align-items: start;
        text-align: start;
        gap: 24px;
        height: 100%;
    }
    .profile-card {
        display: flex;
        justify-content: center;
        align-items: start;
        flex-direction: row;
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
        flex-direction: column;
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

    .card-application{
        width: 50%;
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

    .form-button{
        display: flex;
        flex-direction: row;
        gap: 8px;
        align-items: center;
    }

    @media (max-width: 768px) {
        .card {
            padding: 24px;
        }
    }

    .label {
        font-size: 1rem;
        font-weight: 400;
        color: var(--black-my);
        margin: 0;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin: 0 !important;
    }

    .input-group {
        display: flex;
        align-items: center;
        background-color: var(--main-white);
        border-radius: 16px;
        padding: 0 8px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .form-input {
        width: 100%;
        flex-grow: 1;
        padding: 0.5rem;
        font-size: 1rem;
        border: none;
        outline: none;
        background: transparent;
        color: var(--black-my);
    }


    .form-input::placeholder {
        color: var(--greey-my);
    }

    .form-input:hover::placeholder {
        color: var(--green-dark);
    }

    .form-buttons {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .role-group {
        color: var(--green-dark);
    }

    .role-options {
        display: flex;
        gap: 16px;
        flex-wrap: wrap;
    }

    .role-option {
        display: flex;
        align-items: center;
        font-size: 1rem;
        font-weight: 500;
        gap: 6px;
        cursor: pointer;
    }

    .role-option input[type="checkbox"] {
        width: 16px;
        height: 16px;
        accent-color: var(--green-light);
    }


    .create-button {
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 0.9rem;
        font-weight: 600;
        border-radius: 16px;
        transition: all 0.3s ease-in-out;
        background-color: var(--main-green-dark);
        color: var(--main-white);
        border: none;
        padding: 0.83rem;
        width: 100%;
    }

    .create-button:hover {
        background-color: var(--green-dark);
        transform: scale(1.05);
    }

    .reject-button{
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: fit-content;
        background-color: var(--yellow-my) !important;
        border-radius: 16px;
        border: 1px var(--main-green-dark) solid !important;
        color: var(--main-green-dark) !important;
        gap: 8px;
        font-size: 0.9rem;
        font-weight: 600;
        padding: 0.83rem !important;
        text-align: center;
        cursor: pointer !important;
        text-decoration: none;
        transition: background-color 0.5s ease, color 0.5s ease;
    }

    .label-create {
        display: flex;
        justify-content: center;
        gap: 0.25rem;
        font-size: 0.875rem;
    }

    .label-create p {
        margin: 0;
        color: var(--green-dark);
    }

    .label-create a {
        color: var(--green-light);
        text-decoration: none;
    }
    .label-create a:visited,
    .label-create a:hover,
    .label-create a:focus,
    .label-create a:active {
        color: var(--green-light);
        text-decoration: none;
    }


</style>
