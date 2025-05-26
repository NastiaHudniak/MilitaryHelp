@extends('layouts.app')
@include('layouts.header_military')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <div class="main-content" style="font-family: 'Open Sans', sans-serif;" >
        <div class="card">
            <div class="card-header" style="margin: 0">
                <h2>Оцінка волонтера</h2>
            </div>
            <form class="card-body"  action="{{ route('military.storeRating', $application) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="label" for="category_id">Рейтинг</label>
                    <div class="input-group">
                        <select class="form-input" id="rating" name="rating" placeholder="Оберіть рейтинг">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                        </select>
                    </div>
                    @error('category_id')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-buttons">
                    <button type="submit" class="save-button">Зберегти оцінку</button>
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

    .save-button {
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

    .save-button:hover {
        background-color: var(--green-dark);
        transform: scale(1.05);
    }

    @media (max-width: 768px) {
        .card{
            width: 85%;
        }
    }
</style>
