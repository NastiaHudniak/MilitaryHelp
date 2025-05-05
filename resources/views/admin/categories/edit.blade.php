@extends('layouts.app')
@include('layouts.header_admin')
<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/icon.css') }}" rel="stylesheet">
    <link href="{{ asset('css/global.css') }}" rel="stylesheet">
</head>
@section('content')

    <div class="container" style="max-width: 500px; margin: 0 auto; padding: 100px 0px;">
        <div class="card" style="box-shadow: 0 6px 15px rgba(0, 0, 0, 0.8);">
            <div class="card-header" style="background-color: var(--yellow-400); color: var(--green-800);">
                <h2>Редагування категорії "{{$categories->name}}"</h2>
            </div>
            <div class="card-body" style="background-color: var(--yellow-200);">
                <form id="category-form" action="{{ route('admin.categories.update', $categories->id) }}" method="POST">
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
                        <label for="name">Назва</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $categories->name) }}" required>
                        @error('name')
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
            </div>
        </div>
    </div>
@endsection

