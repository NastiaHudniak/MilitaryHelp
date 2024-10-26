@extends('layouts.app')

@section('content')
    <div class="container" style="max-width: 600px; margin: 0 auto; padding-bottom: 50px;">
        <div class="card" style="box-shadow: 0 6px 15px rgba(0, 0, 0, 0.8);">
            <div class="card-header" style="background-color: #d6d6d6;">
                <h2>Редагування зображень товару "{{$user->name}}"</h2>
            </div>
            <div class="card-body">
                @foreach($images as $image)
                    <div class="image-container mb-3" style="display: flex; align-items: center;">
                        <img src="{{ asset('storage/' . $image->image_url) }}" alt="User Image" style="max-width: 350px; margin-right: 15px;">
                        <form action="{{ route('user.military.account.update_photo', $user) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="new_image">Виберіть нове зображення:</label>
                                <input type="file" name="new_image" id="new_image" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Зберегти нове фото</button>
                        </form>
                    </div>
                @endforeach

                <button type="button" class="btn btn-outline-dark mx-3 mt-3" id="back-button">
                    <i class="fas fa-arrow-left"></i> Назад</button>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('back-button').addEventListener('click', function() {
            window.location.href = "{{ route('user.military.view_account') }}";
        });

        function confirmDelete() {
            return confirm(`Ви точно бажаєте видалити зображення?`);
        }
    </script>
@endsection
