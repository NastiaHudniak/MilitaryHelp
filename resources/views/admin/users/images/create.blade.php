@extends('layouts.app')

@section('content')
    <div class="container" style="max-width: 500px; margin: 0 auto; padding-bottom: 50px;">
        <div class="card" style="box-shadow: 0 6px 15px rgba(0, 0, 0, 0.8);">
            <div class="card-header" style="background-color: #d6d6d6;">
                <h2>Додавання зображення до товару "{{$user->name}}"</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.users.images.store', $user) }}" method="POST" enctype="multipart/form-data">
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
                        <button type="submit" class="btn btn-success">Додати зображення</button>
                        <button type="button" class="btn btn-outline-dark mx-3" id="back-button">
                            <i class="fas fa-arrow-left"></i> Назад</button>
                    </div>

                    <script>
                        document.getElementById('back-button').addEventListener('click', function() {
                            window.location.href = "{{ route('admin.users.index') }}";
                        });
                    </script>
                </form>
            </div>
        </div>
    </div>
@endsection
