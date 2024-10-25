@extends('layouts.app')
@include('layouts.header_volunteer')

@section('content')
    <div class="container" style="max-width: 1300px; padding: 50px 0px;">
        <div class="row mb-4">
            <div class="col-md-4">
                <label for="application-category-filter" class="form-label" style="margin-left: 200px; width: 250px;">Фільтр за категорією заявки</label>
                <div class="input-group" style="width: 250px; margin-left: 200px;">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fas fa-filter"></i>
                        </span>
                    </div>
                    <select id="category-filter" class="form-control">
                        <option value="">Усі заявки</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <div class="input-group-append">
                        <button id="reset-filter" class="btn btn-outline-secondary" type="button">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>

        </div>

        <div id="no-results" class="alert alert-info" style="display: none; text-align: center;">
            Заявок не знайдено.
        </div>

        <div class="row" id="application-card-container">
            @foreach ($applications as $application)
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <div class="card-header" style="background-color: var(--green-400);">
                            <h5 class="card-title" style="color: var(--green-800);">{{ $application->title }}</h5>
                            <h6 class="card-subtitle" style="color: #556155;">{{ $application->category->name }}</h6>
                        </div>
                        <div class="card-body d-flex flex-column" style="background-color: var(--green-300); color: var(--green-800);">
                            <p class="card-text flex-grow-1">{{ $application->description }}</p>
                            <p class="card-text">
                                <strong style="color: #000000;">Статус:</strong>
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
                            <a href="javascript:void(0);" class="btn btn-sm"  data-toggle="modal" data-target="#applicationModal{{ $application->id }}" style="background-color: var(--yellow-500);" >
                                <i class="fas fa-ellipsis-v" style="font-size: 15px;"></i> Переглянути більше
                            </a>
                            <a href="{{ route('user.volunteer.confirm.edit_confirm_app', $application->id) }}" class="btn btn-sm" style="color: var(--green-500);">
                                <i class="fas fa-edit"></i>
                            </a>

                        </div>
                    </div>
                </div>
            @endforeach
            @foreach ($applications as $application)
                <div class="modal fade" id="applicationModal{{ $application->id }}" tabindex="-1" aria-labelledby="applicationModalLabel{{ $application->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: var(--green-400);">
                                <h5 class="modal-title" id="applicationModalLabel{{ $application->id }}">Інформація про заявку</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body" style="background-color: var(--green-300); color: var(--green-800);">
                                <h5>{{ $application->title }}</h5>
                                <p><strong>Категорія:</strong> {{ $application->category->name }}</p>
                                <p><strong>Опис:</strong> {{ $application->description }}</p>
                                <p><strong>Статус:</strong> {{ $application->status }}</p>
                                <p><strong>Коментар:</strong> {{ $application->comment }}</p>
                                <p><strong>Волонтер:</strong> {{ $application->volunteer->name ?? 'Немає' }}</p>
                                <p><strong>Військовий:</strong> {{ $application->millitary->name ?? 'Немає' }}</p>
                            </div>
                            <div class="modal-footer" style="background-color: var(--green-200);">
                                <button type="button" class="btn btn" style="background-color: var(--yellow-500);" data-dismiss="modal">Закрити</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>


    </div>

    <script>
        // Функції для пошуку, фільтрації та підтвердження видалення
        document.getElementById('search').addEventListener('input', function() {
            const query = document.getElementById('search').value;
            const category = document.getElementById('category-filter').value;
            fetchApplications(query, category);
        });

        document.getElementById('reset-filter').addEventListener('click', function() {
            document.getElementById('search').value = '';
            document.getElementById('category-filter').value = '';
            fetchApplications('', '');
        });

        document.getElementById('category-filter').addEventListener('change', function() {
            const query = document.getElementById('search').value;
            const category = document.getElementById('category-filter').value;
            fetchApplications(query, category);
        });

        function fetchApplications(query, category) {
            const url = `{{ route('user.volunteer.filter') }}?query=${encodeURIComponent(query)}&category=${encodeURIComponent(category)}`;
            console.log(url);
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const cardContainer = document.getElementById('application-card-container');
                    const noResults = document.getElementById('no-results');
                    cardContainer.innerHTML = '';

                    if (data.applications.length === 0) {
                        noResults.style.display = 'block';
                    } else {
                        noResults.style.display = 'none';
                        data.applications.forEach(application => {
                            const card = document.createElement('div');
                            card.className = 'col-md-3 mb-4';
                            card.innerHTML = `
                        <div class="card h-100">
                            <div class="card-header" style="background-color: var(--green-400);">
                                <h5 class="card-title" style="color: var(--green-800);">${application.title}</h5>
                                <h6 class="card-subtitle" style="color: #556155;">${application.category.name}</h6>
                            </div>
                            <div class="card-body d-flex flex-column" style="background-color: var(--green-300); color: var(--green-800);">
                                <p class="card-text flex-grow-1">${application.description}</p>
                                <p class="card-text"><strong style="color: #000000;">Статус:</strong> ${application.status}</p>
                            </div>
                            <div class="card-footer" style="background-color: var(--green-200);">
                                <a href="javascript:void(0);" class="btn btn-sm" data-toggle="modal" data-target="#applicationModal${application.id}" style="background-color: var(--yellow-500);">
                                    <i class="fas fa-ellipsis-v" style="font-size: 15px;"></i> Переглянути більше
                                </a>
                                <a href="/user/military/edit/${application.id}" class="btn btn-sm" style="color: var(--green-500);">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="/user/military/destroy/${application.id}" method="POST" style="display:inline;" onsubmit="return confirmDelete('${application.title}')">
                                    @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm" style="color: var(--green-500);">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
`;
                            cardContainer.appendChild(card);
                        });
                    }
                })
                .catch(error => console.error('Error:', error));
        }



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
