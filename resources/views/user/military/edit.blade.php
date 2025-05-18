@extends('layouts.app')
<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/icon.css') }}" rel="stylesheet">
    <link href="{{ asset('css/global.css') }}" rel="stylesheet">
</head>
@include('layouts.header_military_notsearch')
@section('content')
    <img class="background-icon" src="{{ asset('images/pattern.png') }}" alt="Background">
    <div class="container" style="max-width: 500px; margin: 0 auto; padding: 50px 0px;">
        <div class="card" style="box-shadow: 0 6px 15px rgba(0, 0, 0, 0.8);">
            <div class="card-header" style="background-color: var(--yellow-400); color: var(--green-800);">
                <h2>Редагування заявки "{{$applications->title}}"</h2>
            </div>
            <div class="card-body" style="background-color: var(--yellow-200); ">
                <form id="application-form" action="{{ route('user.military.update', $applications->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="title">Назва</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $applications->title) }}" required>
                        @error('title')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="category_id">Категорія</label>
                        <select class="form-control" id="category_id" name="category_id" required>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $category->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Опис</label>
                        <p style="color:red;">*Якщо допомога потрібна терміново, ви можете вказати в кінці опису слово ТЕРМІНОВО</p>
                        <input type="text" class="form-control" id="description" name="description" value="{{ old('description', $applications->description) }}" required>
                        @error('description')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-warning" style="background-color: var(--yellow-500);">Зберегти зміни</button>
                        <button type="button" class="btn btn-outline mx-3" style="color: var(--green-500);border-color: var(--green-500);" id="back-button">
                            <i class="fas fa-arrow-left"></i> Назад</button>
                    </div>
                </form>

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
            </div>
        </div>
    </div>

    @include('layouts.footer')
@endsection

<style>

    .background-icon {
        position: absolute; /* Абсолютне позиціонування, щоб залишалась зверху */
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh; /* Висота в 100% висоти видимої частини екрану */
        object-fit: cover; /* Збереження пропорцій зображення */
        z-index: -1; /* Фон залишається за контентом */
    }
</style>
