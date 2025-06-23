@extends('layouts.app')
@include('layouts.header_admin')
@section('content')
    <div class="main-content" style="font-family: 'Open Sans', sans-serif;">
        <div class="card">
            <div class="card-header" style="margin: 0">
                <h2>Редагування заявки "{{$applications->title}}"</h2>
            </div>
            <form class="card-body" id="application-form" action="{{ route('admin.applications.update', $applications->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label class="label" for="title">Назва</label>
                    <div class="input-group">
                        <input type="text" class="form-input" id="title" name="title" value="{{ old('title', $applications->title) }}" placeholder="Введіть назву" >
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
                        <input type="text" class="form-input" id="description" name="description" placeholder="Введіть опис"  value="{{ old('description', $applications->description) }}" >
                    </div>
                    @error('description')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="label" for="status">Статус</label>
                    <div class="input-group">
                        <select class="form-input" id="status" name="status" required>
                            <option value="створено" {{ (old('status', $applications->status) == 'створено') ? 'selected' : '' }}>Створено</option>
                            <option value="прийнято" {{ (old('status', $applications->status) == 'прийнято') ? 'selected' : '' }}>Прийнято</option>
                        </select>
                    </div>
                    @error('status')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="label" for="comment">Коментар</label>
                    <div class="input-group">
                        <input type="text" class="form-input" id="comment" name="comment" value="{{ old('comment', $applications->comment) }}" >
                    </div>
                    @error('comment')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-groups">
                    <div class="form-groupp">
                        <label class="label" for="volunteer_id">Волонтер</label>
                        <div class="input-group">
                            <select class="form-input" id="volunteer_id" name="volunteer_id" placeholder="Оберіть волонтера" >
                                @foreach ($volunteers as $volunteer)
                                    <option value="{{ $volunteer->id }}" {{ old('volunteer_id', $applications->volunteer_id) == $volunteer->id ? 'selected' : '' }}>
                                        {{ $volunteer->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('volunteer_id')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-groupp">
                        <label class="label" for="millitary_id">Військовий</label>
                        <div class="input-group">
                            <select class="form-input" id="millitary_id" name="millitary_id" placeholder="Оберіть військового" >
                                @foreach ($militaries as $military)
                                    <option value="{{ $military->id }}" {{ old('millitary_id', $applications->millitary_id) == $military->id ? 'selected' : '' }}>
                                        {{ $military->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('millitary_id')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-buttons">
                    <button type="submit" class="register-button">Створити</button>
                    <div class="label-reg">
                        <p>Не хочете створювати?</p>
                        <a id="back-button" href = "{{ route('admin.applications.index') }}">Назад</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
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

                window.location.href = "{{ route('admin.applications.index') }}";
            }
        } else {
            window.location.href = "{{ route('admin.applications.index') }}";
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
        background: linear-gradient(180deg, #FDFDF6 40%, #A3B18A 40%);
        max-width: 100%;
        min-height: 100%;
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
        width: 100%;
        min-width: 5ch;
        max-width: 100%;
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
