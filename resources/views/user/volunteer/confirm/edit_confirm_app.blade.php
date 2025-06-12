@extends('layouts.app')
@include('layouts.header_volunteer')

@section('content')


    <div class="main-content" style="font-family: 'Open Sans', sans-serif;">
        <div class="card">
            <div class="card-header" style="margin: 0">
                <h2>Редагування заявки</h2>
            </div>
            <form class="card-body" action="{{ route('user.volunteer.confirm.update_app', $application->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="label" for="comment">Коментар</label>
                    <div class="input-group">
                        <input type="text" class="form-input" name="comment" id="comment" value="{{ old('comment', $application->comment) }}" placeholder="Введіть коментар" required>
                    </div>
                    @error('comment')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-buttons" style="margin-top: 1rem;">

                    <div class="form-button">
                        <button type="submit" class="create-button">Оновити коментар</button>
                        <form action="{{ route('user.volunteer.confirm.delete_comment', $application->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="button-actions">
                                <img src="{{ asset('images/icon/delete.svg') }}" style="width: 32px; height: 32px">
                            </button>
                        </form>
                        <form action="{{ route('user.volunteer.confirm.reject_application', $application->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="reject-button" >Відхилити заявку</button>
                        </form>

                    </div>


                    <div class="label-create">
                        <p>Не хочете редагувати заявку? </p>
                        <a href="{{ route('user.volunteer.confirm.view_confirm_app') }}">Назад</a>
                    </div>
                </div>
            </form>

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
    }

    .button-actions{
        text-decoration: none;
        border: none;
        background-color: transparent;
        padding: 0;
    }


    .card-header {
        text-align: center;
        color: var(--black-my);
        font-size: 2rem;
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
