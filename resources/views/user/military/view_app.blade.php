@extends('layouts.app')
@include('layouts.header_military')

@section('content')
    <div class="container" style="max-width: 1300px; padding: 50px 0px;">
        <div class="naw">
            <div class="nawb">
                <label for="application-sort-filter" class="form-label" >Додавання нової заявки:</label>
                <div>
                    <a href="{{ route('user.military.create') }}" class="btn" style="width: 260px; white-space: nowrap; background-color: var(--green-500);">
                        <i class="fas fa-plus"></i> Додати заявку
                    </a>
                </div>
            </div>
            <div class="nawb">
                <label for="application-sort-filter" class="form-label" >Сортування за:</label>
                <div class="input-group" style="width: 250px; ">
                    <select id="sort-filter" class="form-control">
                        <option value="latest">Останнi</option>
                        <option value="oldest">Старіші</option>
                        <option value="status">Статус</option>
                    </select>
                </div>
            </div>

            <div class="nawb">
                <label for="application-category-filter" class="form-label" >Фільтр за категорією заявки</label>
                <div class="input-group" style="width: 250px; ">
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

            <div class="nawb">
                <label for="application-status-filter" class="form-label">Фільтр за статусом заявки</label>
                <div class="input-group" style="width: 250px;">
                    <select id="status-filter" class="form-control">
                        <option value="">Усі статуси</option>
                        <option value="created">створено</option>
                        <option value="accept">прийнято</option>
                        <option value="cancel">відхилено</option>
                    </select>
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
                        <div class="image-scroll-container mb-3" style="overflow-x: auto; white-space: nowrap; padding-bottom: 10px;">
                            @foreach ($application->images as $image)
                                <img src="{{ asset('storage/' . $image->image_url) }}" alt="Зображення заявки" class="img-fluid" style="max-height: 150px; object-fit: cover; display: inline-block; margin-right: 10px;">
                            @endforeach
                        </div>
                        <div class="imnav">
                        <a href="{{ route('user.military.images.create', $application) }}" class="btn btn-warning" style="background-color: var(--yellow-500);">
                                <i class="fas fa-add"></i>
                            </a>
                            <a href="{{ route('user.military.images.edit', $application) }}" class="btn btn-warning" style="background-color: var(--yellow-500);">
                                <i class="fas fa-edit"></i>
                            </a>
                        </div>

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
                                <i class="fas fa-ellipsis-v" style="font-size: 15px;"></i> Переглянути
                            </a>
                            <a href="{{ route('user.military.pdf', $application->id) }}" class="btn btn-sm" style="background-color: var(--yellow-500);">PDF</a>

                            <a href="{{ route('user.military.edit', $application) }}" class="btn btn-sm" style="color: var(--green-500);" >
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('user.military.destroy', $application) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete('{{ $application->title }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm" style="color: var(--green-500);" >
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
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
        document.getElementById('search').addEventListener('input', function() {
            const query = document.getElementById('search').value;
            const category = document.getElementById('category-filter').value;
            const status = document.getElementById('status-filter').value;
            const sort = document.getElementById('sort-filter').value;
            fetchApplications(query,  category, sort, status);
        });

        document.getElementById('reset-filter').addEventListener('click', function() {
            const query = document.getElementById('search').value;
            const category = document.getElementById('category-filter').value;
            const sort = document.getElementById('sort-filter').value;
            const status = document.getElementById('status-filter').value;
            document.getElementById('search').value = '';
            document.getElementById('category-filter').value = '';
            fetchApplications(query,  '', sort, status);
        });

        document.getElementById('category-filter').addEventListener('change', function() {
            const query = document.getElementById('search').value;
            const category = document.getElementById('category-filter').value;
            const status = document.getElementById('status-filter').value;
            const sort = document.getElementById('sort-filter').value;
            fetchApplications(query,  category, sort, status);
        });

        document.getElementById('status-filter').addEventListener('change', function() {
             const query = document.getElementById('search').value;
            const category = document.getElementById('category-filter').value;
            const sort = document.getElementById('sort-filter').value;
             const status = document.getElementById('status-filter').value;
             fetchApplications(query,  category, sort, status);
        });

        function fetchApplications(query, category, sort, status) {
            const url = `{{ route('user.military.search') }}?query=${encodeURIComponent(query)}&category=${encodeURIComponent(category)}&sort=${encodeURIComponent(sort)}&status=${encodeURIComponent(status)}`;
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
                            <div class="card-header" style="background-color: var(--green-400); min-height: 93px; max-height: 93px; overflow: hidden; display: flex; flex-direction: column;">
                                <h5 class="card-title" style="color: var(--green-800); margin-bottom: 10px;">${application.title}</h5>
                                <h6 class="card-subtitle" style="color: #556155; margin-bottom: 10px;">${application.category.name}</h6>
                            </div>
                            <div class="card-body d-flex flex-column" style="background-color: var(--green-300); color: var(--green-800);">
                                <div class="image-scroll-container mb-3" style="overflow-x: auto; white-space: nowrap; padding-bottom: 10px;">
                                    ${application.images.map(image => `
                                        <img src="${'{{ asset('storage/') }}' + '/' + image.image_url}" alt="Зображення заявки" class="img-fluid" style="max-height: 150px; object-fit: cover; display: inline-block; margin-right: 10px;">
                                    `).join('')}
                                </div>

                            <p class="card-text flex-grow-1" style="margin-bottom: 10px;">${application.description}</p>
                                <p class="card-text" style="margin-bottom: 10px;">
                                    <strong style="color: #000000;">Статус:</strong>
                                    <span class="${
                                application.status === 'створено' ? 'text-primary' :
                                    application.status === 'прийнято' ? 'text-success' :
                                        'text-danger'
                            }">${application.status}</span>
                                </p>
                            </div>
                            <div class="card-footer" style="background-color: var(--green-200);">
                            <a href="javascript:void(0);" class="btn btn-sm"  data-toggle="modal" data-target="#applicationModal{{ $application->id }}" style="background-color: var(--yellow-my);" >
                                <i class="fas fa-ellipsis-v" style="font-size: 15px;"></i> Переглянути
                            </a>
                            <a href="{{ route('user.military.pdf', $application->id) }}" class="btn btn-sm" style="background-color: var(--yellow-my);">PDF</a>

                            <a href="{{ route('user.military.edit', $application) }}" class="btn btn-sm" style="color: var(--green-light);" >
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('user.military.destroy', $application) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete('{{ $application->title }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm" style="color: var(--green-light);" >
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
`;
                            cardContainer.appendChild(card);
                        });
                    }
                })
                .catch(error => console.error('Error:', error));
        }



        document.getElementById('sort-filter').addEventListener('change', function() {
            const query = document.getElementById('search').value;
            const category = document.getElementById('category-filter').value;
            const sort = document.getElementById('sort-filter').value;
            const status = document.getElementById('status-filter').value;

            fetchApplications(query,  category, sort, status);
        });



        function confirmDelete(title) {
            return confirm(`Ви впевнені, що хочете видалити заявку "${title}"?`);
        }
    </script>

    @include('layouts.footer_military')
@endsection

<style>
.image-scroll-container::-webkit-scrollbar {
    height: 8px;
}

.image-scroll-container::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.image-scroll-container::-webkit-scrollbar-thumb {
    background: var(--green-dark);
    border-radius: 10px;
}

.image-scroll-container::-webkit-scrollbar-thumb:hover {
    background: #45a049;
}
.image-scroll-container img {
    height: 150px;
    width: auto;
    object-fit: cover;
    display: inline-block;
    margin-right: 10px;
}

.imnav{
    display: flex;
        flex-direction: row;
        justify-content: end;
        gap: 10px;
}


    .btn {
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .btn:hover {
        background-color: var(--green-dark);
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

    .naw{
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        padding: 30px 0;
    }
</style>
