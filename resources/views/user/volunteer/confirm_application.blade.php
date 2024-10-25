@extends('layouts.app')
@include('layouts.header_volunteer')

@section('content')
    <div class="container" style="max-width: 1300px; padding: 50px 0px;">
        <div class="row">
            <!-- Ліва колонка: інформація про військового -->
            <div class="col-md-6">
                <h3>Інформація про військового</h3>
                <p><strong>Ім'я:</strong> {{ $millitary->name }} {{ $millitary->surname }}</p>
                <p><strong>Email:</strong> {{ $millitary->email }}</p>
                <p><strong>Телефон:</strong> {{ $millitary->phone }}</p>
                <p><strong>Адреса:</strong> {{ $millitary->address }}</p>

                <h4>Залишити коментар</h4>
                <form action="{{ route('user.volunteer.confirm_application.confirm', $application->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="comment">Коментар</label>
                        <textarea name="comment" class="form-control" rows="3">{{ $application->comment === 'немає' ? '' : $application->comment }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Підтвердити заявку</button>
                </form>
            </div>

            <!-- Права колонка: інформація про заявку -->
            <div class="col-md-6">
                <h3>Інформація про заявку</h3>
                <p><strong>Заголовок:</strong> {{ $application->title }}</p>
                <p><strong>Опис:</strong> {{ $application->description }}</p>
                <p><strong>Категорія:</strong> {{ $application->category->name }}</p>
                <p><strong>Статус:</strong> {{ $application->status }}</p>
            </div>
        </div>

        <!-- Кнопка для повернення -->
        <div class="row mt-4">
            <div class="col-md-12">
                <a href="{{ route('user.volunteer.view_military') }}" class="btn btn-secondary">Повернутись назад</a>
            </div>
        </div>
    </div>
@endsection


<style>
    .btn {
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .btn:hover {
        background-color: var(--green-800);
        text-decoration: none;
        transform: scale(1.1);
    }

</style>
