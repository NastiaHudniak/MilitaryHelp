@extends('layouts.app')
@include('layouts.header_volunteer_notsearch')

@section('content')
    <img class="background-icon" src="{{ asset('images/pattern.png') }}" alt="Background">
    <div class="container" style="max-width: 500px; margin: 0 auto; padding: 110px 0px;">
        <div class="card" style="box-shadow: 0 6px 15px rgba(0, 0, 0, 0.8);">
            <div class="card-header" style="background-color: var(--yellow-400); color: var(--green-800);">
                <h2>Редагування заявки</h2>
            </div>
            <div class="card-body" style="background-color: var(--yellow-200); ">
                <form action="{{ route('user.volunteer.confirm.update_app', $application->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="comment">Коментар</label>
                        <input type="text" name="comment" id="comment" value="{{ old('comment', $application->comment) }}" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-warning" style="background-color: var(--yellow-500);margin-bottom: 10px;">Оновити коментар</button>
                </form>

                <form action="{{ route('user.volunteer.confirm.delete_comment', $application->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn" style="background-color: var(--green-400);">Видалити коментар</button>
                </form>

                <form action="{{ route('user.volunteer.confirm.reject_application', $application->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-outline mx-3" style="color: var(--green-500);border-color: var(--green-500);">Відхилити заявку</button>
                </form>
            </div>
        </div>
    </div>
    
    @include('layouts.footer_volunteer') 
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