@extends('layouts.app')
<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/icon.css') }}" rel="stylesheet">
    <link href="{{ asset('css/global.css') }}" rel="stylesheet">
</head>
@include('layouts.header_military')
@section('content')
    <div class="main-content" style="font-family: 'Open Sans', sans-serif;">
        <div class="card">
            <div class="card-header" style="margin: 0">
                <h2>Редагування заявки</h2>
                <a class="card-header-name">"{{$applications->title}}"</a>
            </div>
            <form class="card-body" id="application-form" action="{{ route('user.military.update', $applications->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label class="label" for="title">Назва</label>
                    <div class="input-group">
                        <input type="text" class="form-input" id="title" name="title" placeholder="Введіть назву" value="{{ old('title', $applications->title) }}" >
                    </div>
                    @error('title')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="label" for="category_id">Категорія</label>
                    <div class="input-group">
                        <select class="form-input" id="category_id" name="category_id" placeholder="Оберіть категорію" >
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $category->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('category_id')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="label" for="description">Опис</label>
                    <div class="input-group">
                        <input type="text" class="form-input" id="description" name="description" placeholder="Введіть опис" value="{{ old('description', $applications->description) }}" >
                    </div>
                    @error('description')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-buttons">
                    <button type="submit" class="update-button">Зберегти</button>
                    <div class="label-create">
                        <p>Не хочете змінювати заявку? </p>
                        <a  id="back-button" href="{{ route('user.military.index') }}">Назад</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @include('layouts.footer')
@endsection

<script>
    let formChanged = false;
    const form = document.getElementById('application-form');
    const backButton = document.getElementById('back-button');


    form.addEventListener('change', function() {
        formChanged = true;
    });


    backButton.addEventListener('click', function() {
        if (formChanged) {
            const confirmLeave = confirm("Ви внесли зміни. Бажаєте зберегти їх перед тим, як вийти?");
            if (confirmLeave) {
                form.submit();
            } else {

                window.location.href = "{{ route('user.military.view_app') }}";
            }
        } else {
            window.location.href = "{{ route('user.military.view_app') }}";
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
        display: flex;
        align-items: start;
        justify-content: center;
        padding-top: 20px;
        min-height: 80vh;
        gap: 20px;
    }

    .card {
        width: 100%;
        max-width: 450px;
        border: none !important;
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        background-color: transparent;
        padding: 24px 0;
    }



    .card-header {
        text-align: center;
        color: var(--black-my);
        font-size: 2rem;
        font-weight: 700;
        background-color: transparent !important;
        border: none !important;
    }

    .card-header-name{
        text-align: center;
        color: var(--green-dark);
        font-size: 1rem;
        font-weight: 700;
        background-color: transparent !important;
        border: none !important;
    }

    .card-body {
        display: flex;
        flex-direction: column;
        gap: 24px;
        background-color: var(--yellow-my);
        border-radius: 16px;
        padding: 2rem;
        margin: 0;
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
