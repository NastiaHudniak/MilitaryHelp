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
                <h2>Редагування зображень товару "{{$application->title}}"</h2>
            </div>
            <div class="card-body" style="background-color: var(--yellow-200);">
                @foreach($images as $image)
                    <div class="image-container mb-3" style="display: flex; align-items: center;">
                        <img src="{{ asset('storage/' . $image->image_url) }}" alt="Product Image" style="width: 200px; height: 200px; object-fit: cover; margin-right: 15px;">
                        <form action="{{ route('user.military.images.delete', [$application, $image]) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="margin-left: 30px" onclick="return confirmDelete()">
                                <i class="fas fa-trash"></i> Видалити
                            </button>
                        </form>
                    </div>
                @endforeach

                <a href="{{ route('user.military.images.create', $application) }}" class="btn btn-warning" style="background-color: var(--yellow-500);">
                    <i class="fas fa-plus"></i> Додати нове зображення
                </a>
                <button type="button" class="btn btn-outline mx-3" style="color: var(--green-500);border-color: var(--green-500);" id="back-button">
                    <i class="fas fa-arrow-left"></i> Назад</button>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('back-button').addEventListener('click', function() {
            window.location.href = "{{ route('user.military.view_app') }}";
        });

        function confirmDelete() {
            return confirm(`Ви точно бажаєте видалити зображення?`);
        }
    </script>
     @include('layouts.footer')
@endsection
