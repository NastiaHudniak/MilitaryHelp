@extends('layouts.app')
@include('layouts.header_military_notsearch')
@section('content')
    <img class="background-icon" src="{{ asset('images/pattern.png') }}" alt="Background">
    <div class="container" style="max-width: 500px; margin: 0 auto; padding-bottom: 40px;">
        <div class="card" style="margin-top: 100px; box-shadow: 0 6px 10px rgba(0, 0, 0, 0.6);">
            <div class="card-header" style="background-color: var(--yellow-400); color: var(--green-800);">
                <h2>Додавання нової заявки</h2>
            </div>
            <div class="card-body" style="background-color: #FCFDE1;">
                <form action="{{ route('user.military.store') }}" method="POST">
                    @csrf
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="form-group" style=" color: var(--green-800);">
                        <label for="title">Назва</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                        @error('title')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group" style=" color: var(--green-800);">
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

                    <div class="form-group" style=" color: var(--green-800);">
                        <label for="description">Опис</label>
                        <input type="text" class="form-control" id="description" name="description" value="{{ old('description') }}" required>
                        @error('description')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-warning" style="background-color: var(--yellow-500);">Створити заявку</button>
                        <button type="button" class="btn btn-outline mx-3" style="color: var(--green-500);border-color: var(--green-500);" id="back-button">
                            <i class="fas fa-arrow-left"  ></i> Назад</button>
                    </div>

                    <script>
                        document.getElementById('back-button').addEventListener('click', function() {
                            window.location.href = "{{ route('user.military.index') }}";
                        });





                    </script>
                </form>
            </div>
        </div>
    </div>
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

