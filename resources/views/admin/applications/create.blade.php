@extends('layouts.app')
@include('layouts.header_admin')
<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/icon.css') }}" rel="stylesheet">
    <link href="{{ asset('css/global.css') }}" rel="stylesheet">
</head>
@section('content')

    <div class="container" style="max-width: 500px; margin: 0 auto; padding: 50px 0px;">
        <div class="card" style="box-shadow: 0 6px 15px rgba(0, 0, 0, 0.8);">
            <div class="card-header" style="background-color: var(--yellow-400); color: var(--green-800);">
                <h2>Додавання нової заявки</h2>
            </div>
            <div class="card-body" style="background-color: var(--yellow-200);">
                <form action="{{ route('admin.applications.store') }}" method="POST">
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
                    <div class="form-group">
                        <label for="title">Назва</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
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
                        <input type="text" class="form-control" id="description" name="description" value="{{ old('description') }}" required>
                        @error('description')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="status">Статус</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="створено" {{ old('status') == 'створено' ? 'selected' : '' }}>Створено</option>
                            <option value="прийнято" {{ old('status') == 'прийнято' ? 'selected' : '' }}>Прийнято</option>
                        </select>
                        @error('status')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="comment">Коментар</label>
                        <input type="text" class="form-control" id="comment" name="comment" value="немає" readonly>
                        @error('comment')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
    <label for="volunteer_id">Волонтер</label>
    <select class="form-control" id="volunteer_id" name="volunteer_id" disabled>
        <option value="">Виберіть волонтера</option>
        @foreach ($volunteers as $volunteer)
            <option value="{{ $volunteer->id }}" {{ old('volunteer_id') == $volunteer->id ? 'selected' : '' }}>
                {{ $volunteer->name }}
            </option>
        @endforeach
    </select>
    @error('volunteer_id')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="millitary_id">Військовий</label>
    <select class="form-control" id="millitary_id" name="millitary_id" required>
        <option value="">Виберіть військового</option>
        @foreach ($militaries as $military)
            <option value="{{ $military->id }}" {{ old('millitary_id') == $military->id ? 'selected' : '' }}>
                {{ $military->name }}
            </option>
        @endforeach
    </select>
    @error('millitary_id')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>


                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-warning" style="background-color: var(--yellow-500);">Створити заявку</button>
                        <button type="button" class="btn btn-outline mx-3" style="color: var(--green-500);border-color: var(--green-500);" id="back-button">
                            <i class="fas fa-arrow-left"></i> Назад
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('back-button').addEventListener('click', function() {
            window.location.href = "{{ route('admin.applications.index') }}";
        });

        document.getElementById('status').addEventListener('change', function() {
            const commentField = document.getElementById('comment');
            const volunteerField = document.getElementById('volunteer_id');

            if (this.value === 'створено') {
                commentField.value = 'немає';
                commentField.readOnly = true;
                volunteerField.value = '';
                volunteerField.disabled = true;
            } else {
                commentField.value = '';
                commentField.readOnly = false;
                volunteerField.disabled = false;
            }
        });
    </script>

@endsection
