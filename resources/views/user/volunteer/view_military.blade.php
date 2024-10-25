@extends('layouts.app')
@include('layouts.header_volunteer')

@section('content')
    <div class="container" style="max-width: 1300px; padding: 50px 0px;">
        <div class="row mb-4">
            <div class="col-md-4">
                <h3>Список військових</h3>
            </div>
        </div>

        <div id="no-results" class="alert alert-info" style="display: none; text-align: center;">
            Волонтерів не знайдено.
        </div>

        <div class="row" id="military-card-container">
            @foreach ($militaries as $military)
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <div class="card-header" style="background-color: var(--green-400);">
                            <h5 class="card-title" style="color: var(--green-800);">{{ $military->name }}</h5>
                            <h5 class="card-title" style="color: var(--green-800);">{{ $military->surname }}</h5>
                        </div>
                        <div class="card-body" style="background-color: var(--green-300); color: var(--green-800);">
                            <p class="card-text"><strong>Email:</strong> {{ $military->email }}</p>
                            <p class="card-text"><strong>Телефон:</strong> {{ $military->phone }}</p>
                            <p class="card-text"><strong>Адреса:</strong> {{ $military->address }}</p>
                        </div>
                        <div class="card-footer" style="background-color: var(--green-200);">
                            <a href="{{ route('user.volunteer.view_info_military', $military->id) }}" class="btn btn-sm" style="color: var(--green-500);">
                                <i class="fas fa-eye"></i> Переглянути
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        document.getElementById('search').addEventListener('input', function() {
            const query = document.getElementById('search').value;
            fetchVolunteers(query);
        });

        {{--function fetchVolunteers(query) {--}}
        {{--    fetch(`{{ route('user.military.filter_volunteers') }}?query=${encodeURIComponent(query)}`)--}}
        {{--        .then(response => response.json())--}}
        {{--        .then(data => {--}}
        {{--            const cardContainer = document.getElementById('volunteer-card-container');--}}
        {{--            const noResults = document.getElementById('no-results');--}}
        {{--            cardContainer.innerHTML = '';--}}

        {{--            if (data.volunteers.length === 0) {--}}
        {{--                noResults.style.display = 'block';--}}
        {{--            } else {--}}
        {{--                noResults.style.display = 'none';--}}
        {{--                data.volunteers.forEach(volunteer => {--}}
        {{--                    const card = document.createElement('div');--}}
        {{--                    card.className = 'col-md-3 mb-4';--}}
        {{--                    card.innerHTML = `--}}
        {{--                        <div class="card h-100">--}}
        {{--                            <div class="card-header" style="background-color: var(--green-400);">--}}
        {{--                                <h5 class="card-title" style="color: var(--green-800);">${volunteer.name} ${volunteer.surname}</h5>--}}
        {{--                            </div>--}}
        {{--                            <div class="card-body" style="background-color: var(--green-300); color: var(--green-800);">--}}
        {{--                                <p class="card-text"><strong>Email:</strong> ${volunteer.email}</p>--}}
        {{--                                <p class="card-text"><strong>Телефон:</strong> ${volunteer.phone}</p>--}}
        {{--                                <p class="card-text"><strong>Адреса:</strong> ${volunteer.address}</p>--}}
        {{--                            </div>--}}
        {{--                            <div class="card-footer" style="background-color: var(--green-200);">--}}
        {{--                                <a href="{{ route('user.military.viewVolunteer', ${volunteer.id}) }}" class="btn btn-sm" style="color: var(--green-500);">--}}
        {{--                                    <i class="fas fa-eye"></i> Переглянути--}}
        {{--                                </a>--}}
        {{--                            </div>--}}
        {{--                        </div>--}}
        {{--                    `;--}}
        {{--                    cardContainer.appendChild(card);--}}
        {{--                });--}}
        {{--            }--}}
        {{--        })--}}
        {{--        .catch(error => console.error('Error:', error));--}}
        {{--}--}}
    </script>
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
        min-height: 93px; /* Фіксована мінімальна висота для card-header */
        max-height: 93px; /* Фіксована максимальна висота для card-header */
        overflow: hidden; /* Обмеження тексту, якщо він виходить за межі */
        display: flex;
        flex-direction: column;
    }

    .card-footer{
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }

    .card-text {
        margin-bottom: 10px;
    }

    .card-title, .card-subtitle {
        margin-bottom: 10px;
    }

    .h-100 {
        height: 100%;
    }
</style>
