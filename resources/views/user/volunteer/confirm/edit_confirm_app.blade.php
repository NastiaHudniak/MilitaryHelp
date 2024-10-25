@extends('layouts.app')
@include('layouts.header_volunteer')

@section('content')
    <div class="container">
        <h2>Редагувати заявку</h2>

        <form action="{{ route('user.volunteer.confirm.update_app', $application->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="comment">Коментар</label>
                <input type="text" name="comment" id="comment" value="{{ old('comment', $application->comment) }}" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Оновити коментар</button>
        </form>

        <form action="{{ route('user.volunteer.confirm.delete_comment', $application->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('PUT')

            <button type="submit" class="btn btn-danger">Видалити коментар</button>
        </form>

        <form action="{{ route('user.volunteer.confirm.reject_application', $application->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('PUT')

            <button type="submit" class="btn btn-warning">Відхилити заявку</button>
        </form>

    </div>
@endsection
