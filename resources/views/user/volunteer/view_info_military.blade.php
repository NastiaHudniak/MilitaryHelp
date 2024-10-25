@extends('layouts.app')
@include('layouts.header_volunteer')

@section('content')
    <div class="container" style="max-width: 1300px; padding: 50px 0px;">
        <div class="row">
            <!-- Left block: Military personnel information -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header" style="background-color: var(--green-400);">
                        <h4>Інформація про військового</h4>
                    </div>
                    <div class="card-body" style="background-color: var(--green-300); color: var(--green-800);">
                        <p><strong>Ім'я:</strong> {{ $millitary->name }}</p>
                        <p><strong>Прізвище:</strong> {{ $millitary->surname }}</p>
                        <p><strong>Логін:</strong> {{ $millitary->login }}</p>
                        <p><strong>Телефон:</strong> {{ $millitary->phone }}</p>
                        <p><strong>Пошта:</strong> {{ $millitary->email }}</p>
                        <p><strong>Адреса:</strong> {{ $millitary->address }}</p>
                        <!-- Add any other military personnel fields you need -->
                    </div>
                </div>
            </div>

            <!-- Right block: Military applications -->
            <div class="col-md-8">
                <h4 class="mb-4">Заявки військового</h4>
                <div class="row">
                    @foreach ($applications as $application)
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-header" style="background-color: var(--green-400);">
                                    <h5 class="card-title" style="color: var(--green-800);">{{ $application->title }}</h5>
                                    <h6 class="card-subtitle" style="color: #556155;">{{ $application->category->name }}</h6>
                                </div>
                                <div class="card-body d-flex flex-column" style="background-color: var(--green-300); color: var(--green-800);">
                                    <p class="card-text flex-grow-1">{{ $application->description }}</p>
                                    <p class="card-text">
                                        <strong>Статус:</strong>
                                        <span class="
                                            @if ($application->status === 'створено') text-primary
                                            @elseif ($application->status === 'прийнято') text-success
                                            @elseif ($application->status === 'відхилено') text-danger
                                            @endif
                                        ">
                                        {{ $application->status }}
                                        </span>
                                    </p>
                                </div>
                                <div class="card-footer" style="background-color: var(--green-200);">
                                    <a href="{{ route('user.volunteer.confirm_application', ['id' => $application->id]) }}" class="btn btn-sm" style="background-color: var(--yellow-500);">
                                        <i class="fas fa-ellipsis-v"></i> Переглянути більше
                                    </a>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
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

    .card {
        transition: box-shadow 0.3s ease;
        box-shadow: 0 6px 10px rgba(43, 67, 36, 0.6);
    }

    .card:hover {
        box-shadow: 0px 0px 15px rgba(43, 67, 36, 0.3);
        transform: scale(1.01);
    }

    .card-body {
        display: flex;
        flex-direction: column;
    }

    .card-header {
        min-height: 93px;
        max-height: 93px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .card-footer {
        display: flex;
        justify-content: space-between;
    }
</style>
