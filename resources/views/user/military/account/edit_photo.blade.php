@extends('layouts.app')
@include('layouts.header_military')
@section('content')
    <div class="main-content" style="font-family: 'Open Sans', sans-serif;">
        <div class="main-info">
            @include('components.sidebar_account', ['user' => $user])
            @foreach($images as $image)
                <div class="profile-card">
                    <div class="profile-photo">
                        <img src="{{ asset('storage/' . $image->image_url) }}" alt="User Image" >
                    </div>
                    <div class="profile-info">
                        <p class="profile-info-title">
                            Редагування фото
                        </p>
                        <form class="card-body" action="{{ route('user.military.account.update_photo', $user) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label class="custom-file-upload">
                                    <input type="file" class="form-input" id="new_image" name="new_image"  placeholder="Оберіть фото" >
                                    Вибрати файл
                                </label>
                            </div>
                            <div class="form-buttons">
                                <button type="submit" class="update-button">Зберегти зміни</button>
                                <div class="label-ed">
                                    <p>Не хочете змінювати дані?</p>
                                    <a id="back-button" href="{{ route('user.military.view_account') }}">Повернутись</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <script>
        document.getElementById('back-button').addEventListener('click', function() {
            window.location.href = "{{ route('user.military.view_account') }}";
        });

        function confirmDelete() {
            return confirm(`Ви точно бажаєте видалити зображення?`);
        }
    </script>

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
        align-items: start;
        padding: 64px 80px;
        gap: 80px;
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

    }

    .profile-card {
        width: 100%;
        max-width: 1000px;
        display: flex;
        justify-content: center;
        align-items: center;
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
        width: 300px;
        height: 300px;
        object-fit: cover;
        border-radius: 50%;
    }

    .profile-info{
        width: 100%;
        max-width: 1000px;
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
        border: none !important;
        padding: 0 !important;
    }


    .card-body {
        width: 100%;
        max-width: 400px;
        display: flex;
        flex-direction: column;
        gap: 24px;
        background-color: var(--yellow-my);
        border-radius: 16px;
        padding: 2rem;
        margin: 0;
    }

    @media (max-width: 768px) {
        .profile-card{
            flex-direction: column;
            gap: 16px;
        }

        .profile-info-title{
            font-size: 32px;
        }

        .profile-info{
            align-items: center;
        }

        .profile-photo img {
            width: 120px;
            height: 120px;
        }
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin: 0 !important;
    }

    input[type="file"] {
        display: none;
    }

    .custom-file-upload {
        display: inline-block;
        padding: 10px 20px;
        background-color: var(--main-white);
        color: var(--black-my);
        border-radius: 16px;
        cursor: pointer;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        transition: background-color 0.3s ease;
        user-select: none;
    }


    .form-input {
        flex-grow: 1;
        padding: 0.5rem;
        font-size: 1rem;
        border: none;
        outline: none;
        background: transparent;
        color: var(--black-my);
        width: auto;
        min-width: 5ch;
        max-width: 80%;
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

    .update-button {
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 1rem;
        font-weight: 600;
        border-radius: 16px;
        transition: all 0.3s ease-in-out;
        background-color: var(--main-green-dark);
        color: var(--main-white);
        border: none;
        padding: 0.83rem;
    }

    .update-button:hover {
        background-color: var(--green-dark);
        transform: scale(1.05);
    }

    .label-ed {
        display: flex;
        justify-content: center;
        gap: 0.25rem;
        font-size: 0.875rem;
    }

    .label-ed p {
        margin: 0;
        color: var(--green-dark);
    }

    .label-ed a {
        color: var(--green-light);
        text-decoration: none;
    }
    .label-ed a:visited,
    .label-ed a:hover,
    .label-ed a:focus,
    .label-ed a:active {
        color: var(--green-light);
        text-decoration: none;
    }

</style>
