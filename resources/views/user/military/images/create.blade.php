@extends('layouts.app')

@include('layouts.header_military')
<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/icon.css') }}" rel="stylesheet">
    <link href="{{ asset('css/global.css') }}" rel="stylesheet">
</head>
@section('content')
<div class="container" style="max-width: 500px; margin: 0 auto; padding: 100px 0px;">
        <div class="card" style="box-shadow: 0 6px 15px rgba(0, 0, 0, 0.8);">
            <div class="card-header" style="background-color: var(--yellow-400); color: var(--green-800);">
                <h2>Додавання зображення до заявки "{{$application->title}}"</h2>
            </div>
            <div class="card-body" style="background-color: var(--yellow-200);">
                <form action="{{ route('user.military.images.store', $application) }}" method="POST" enctype="multipart/form-data">
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
                        <label for="image" class="form-label">Зображення</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="image" name="image" required>
                            <label class="custom-file-label" for="image" id="file-name">Файл не вибрано</label>
                        </div>
                        @error('image')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <style>
                        .custom-file-input:lang(en) ~ .custom-file-label::after {
                            content: "Вибрати";
                            background-color: #d6d6d6;
                        }
                    </style>

                    <script>
                        document.getElementById('image').addEventListener('change', function() {
                            var fileName = this.files[0] ? this.files[0].name : 'Файл не вибрано';
                            document.getElementById('file-name').textContent = fileName;
                        });
                    </script>

                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-warning" style="background-color: var(--yellow-500);">Додати зображення</button>
                        <button type="button" class="btn btn-outline mx-3" style="color: var(--green-500);border-color: var(--green-500);" id="back-button">
                            <i class="fas fa-arrow-left"></i> Назад</button>
                    </div>

                    <script>
                        document.getElementById('back-button').addEventListener('click', function() {
                            window.location.href = "{{ route('user.military.view_app') }}";
                        });
                    </script>
                </form>
            </div>
        </div>
    </div>
    @include('layouts.footer')
@endsection
