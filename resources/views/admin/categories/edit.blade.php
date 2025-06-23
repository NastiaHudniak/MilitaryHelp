@extends('layouts.app')
@include('layouts.header_admin')

@section('content')
    <div class="main-content" style="font-family: 'Open Sans', sans-serif;">
        <div class="card">
            <div class="card-header" style="margin: 0">
                <h2>Редагування категорії "{{$categories->name}}"</h2>
            </div>
            <form class="card-body" id="category-form" action="{{ route('admin.categories.update', $categories->id) }}" method="POST">
                @csrf

                @method('PUT')
                <div class="form-group">
                    <label class="label" for="name">Назва</label>
                    <div class="input-group">
                        <input type="text" class="form-input" id="name" name="name" value="{{ old('name', $categories->name) }}" placeholder="Введіть назву" >
                    </div>
                    @error('name')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-buttons">
                    <button type="submit" class="register-button">Зберегти</button>
                    <div class="label-reg">
                        <p>Не хочете змінювати?</p>
                        <a id="back-button" href = "{{ route('admin.categories.index') }}">Назад</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

<style>
    body {
        overflow-x: hidden;
    }

    * {
        box-sizing: border-box;
    }

    .main-content {
        background: linear-gradient(180deg, #FDFDF6 40%, #A3B18A 40%);
        max-width: 100%;
        margin: 0 auto;
        display: flex;
        justify-content: center;
        padding: 32px;
    }

    .card {
        width: 100%;
        max-width: 450px;
        border: none !important;
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        background-color: transparent !important;
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
        gap: 16px;
        background-color: var(--yellow-my);
        border-radius: 16px;
        padding: 1.2rem 2rem;
        margin: 0;
    }

    .label {
        font-size: 1rem;
        font-weight: 400;
        color: var(--black-my);
        margin: 0;
    }

    .form-groups {
        width: 100%;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        gap: 6px;
        margin: 0;
    }



    .form-group {
        display: flex;
        flex-direction: column;
        gap: 4px;
        margin: 0;
    }
    .form-groupp {
        width: 50%;
        display: flex;
        flex-direction: column;
        gap: 4px;
        margin: 0;
    }

    .input-group {
        display: flex;
        flex-direction: row;
        align-items: center;
        background-color: var(--main-white);
        border-radius: 16px;
        padding: 0 8px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    @media (max-width: 768px) {
        .form-groups {
            width: 100%;
            flex-direction: column;
            gap: 16px;
        }
        .form-groupp {
            width: 100%;
        }
        .input-group{
            justify-content: space-between;
        }
    }


    .form-input {
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

    .toggle-password, .toggle-password-confirmation {
        background: transparent;
        border: none;
        padding: 0.5rem;
        cursor: pointer;
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

    .role-option input[type="radio"] {
        width: 16px;
        height: 16px;
        accent-color: var(--green-light);
    }


    .form-buttons {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .register-button {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 0.75rem;
        font-size: 1rem;
        font-weight: 600;
        border-radius: 16px;
        transition: all 0.3s ease-in-out;
        background-color: var(--main-green-dark);
        color: var(--main-white);
        border: none;
    }

    .register-button:hover {
        background-color: var(--green-dark);
        transform: scale(1.05);
    }

    .label-reg {
        display: flex;
        justify-content: center;
        gap: 0.25rem;
        font-size: 0.875rem;
    }

    .label-reg p {
        margin: 0;
        color: var(--green-dark);
    }

    .label-reg a {
        color: var(--green-light);
        text-decoration: none;
    }

    .label-reg a:hover {
        text-decoration: underline;
    }
</style>
<script>
    let formChanged = false;
    const form = document.getElementById('category-form');
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

                window.location.href = "{{ route('admin.categories.index') }}";
            }
        } else {
            window.location.href = "{{ route('admin.categories.index') }}";
        }
    });
</script>
