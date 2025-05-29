@extends('layouts.app')
@include('layouts.header_volunteer')
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')


    <div class="main-content" style="font-family: 'Open Sans', sans-serif;">
        <div class="naw">
            <div class="nawb">
                <label for="application-sort-filter" class="form-label" >Сортування за:</label>
                <div class="input-group" style="width: 250px; ">
                    <select id="sort-filter" class="form-control">
                        <option value="latest">Останнi</option>
                        <option value="oldest">Старіші</option>
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
        </div>


        <div id="no-results" class="alert alert-info" style="display: none; text-align: center;">
            Заявок не знайдено.
        </div>

        <div class="application-block" id="application-card-container">
            @foreach ($applications as $application)
                @include('components.application-card-vol', ['application' => $application])
            @endforeach
        </div>

    </div>


     @include('layouts.footer')

    <script>
        // document.getElementById('search').addEventListener('input', function() {
        //     const query = document.getElementById('search').value;
        //     const category = document.getElementById('category-filter').value;
        //     const sort = document.getElementById('sort-filter').value;
        //     fetchApplications(query,  category, sort);
        // });
        //
        // document.getElementById('reset-filter').addEventListener('click', function() {
        //     const query = document.getElementById('search').value;
        //     const category = document.getElementById('category-filter').value;
        //     const sort = document.getElementById('sort-filter').value;
        //     document.getElementById('search').value = '';
        //     document.getElementById('category-filter').value = '';
        //     fetchApplications(query,  '', sort);
        // });
        //
        // document.getElementById('category-filter').addEventListener('change', function() {
        //     const query = document.getElementById('search').value;
        //     const category = document.getElementById('category-filter').value;
        //     const sort = document.getElementById('sort-filter').value;
        //     fetchApplications(query,  category, sort);
        // });
        //
        //
        // document.getElementById('sort-filter').addEventListener('change', function() {
        //     const query = document.getElementById('search').value;
        //     const category = document.getElementById('category-filter').value;
        //     const sort = document.getElementById('sort-filter').value;
        //
        //     fetchApplications(query,  category, sort);
        // });


        function fetchApplications(query, category, sort) {
            const url = `{{ route('user.volunteer.search') }}?query=${encodeURIComponent(query)}&category=${encodeURIComponent(category)}&sort=${encodeURIComponent(sort)}`;
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
                                <div class="image-scroll-container mb-3" style="overflow-x: auto; white-space: nowrap; padding-bottom: 10px;">
                                    ${application.images.map(image => `
                                        <img src="${'{{ asset('storage/') }}' + '/' + image.image_url}" alt="Зображення заявки" class="img-fluid" style="max-height: 150px; object-fit: cover; display: inline-block; margin-right: 10px;">
                                    `).join('')}
                                </div>
     <p class="card-text flex-grow-1">${application.description}</p>
                                <p class="card-text"><strong style="color: #000000;">Статус:</strong> ${application.status}</p>
                            </div>
                           <div class="card-footer" style="background-color: var(--green-200);">
                            <a href="javascript:void(0);" class="btn btn-sm"  data-toggle="modal" data-target="#applicationModal{{ $application->id }}" style="background-color: var(--yellow-500);" >
                                <i class="fas fa-ellipsis-v" style="font-size: 15px;"></i> Переглянути більше
                            </a>
                            <a href="{{ route('user.volunteer.confirm_application', ['id' => $application->id]) }}" class="btn btn-sm" style="background-color: var(--yellow-500);">
                                <span class="lets-icons--done-ring-round"></span>
                            </a>
                            <a href="{{ route('user.volunteer.pdf', $application->id) }}" class="btn btn-sm" style="background-color: var(--yellow-500);">PDF</a>

                        </div>
                </div>
`;
                            cardContainer.appendChild(card);
                        });
                    }
                })
                .catch(error => console.error('Error:', error));
        }


        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll('.like-btn .like-icon').forEach(function (icon) {
                icon.addEventListener('click', function (e) {
                    e.stopPropagation();

                    const btn = icon.closest('.like-btn');
                    const applicationId = btn.dataset.id;
                    const outlineSrc = icon.dataset.outline;
                    const filledSrc = icon.dataset.filled;

                    fetch(`/applications/like/toggle/${applicationId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({})
                    })
                        .then(response => {
                            if (!response.ok) {
                                if (response.status === 401) {
                                    alert('Спочатку увійдіть, щоб поставити лайк!');
                                    return;
                                }
                                throw new Error('Помилка мережі');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (!data) return;

                            if (data.status === 'added') {
                                icon.setAttribute('src', filledSrc);
                                btn.classList.add('liked');
                            } else if (data.status === 'removed') {
                                icon.setAttribute('src', outlineSrc);
                                btn.classList.remove('liked');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Сталася помилка.');
                        });
                });
            });
        });
    </script>
@endsection

<style>
    body {
        overflow-x: hidden;
    }

    * {
        box-sizing: border-box;
    }

    .main-content {
        background-color: var(--main-white);
        max-width: 100%;
        margin: 0 auto;
    }

    .filters-blocks{
        width: 100%;
        height: fit-content;
        display: inline-flex;
        justify-content: space-between;
        flex-direction: column;
        gap: 24px;
        padding: 24px 80px;
    }

    .navigation-bar{
        width: 100%;
        height: fit-content;
        display: inline-flex;
        justify-content: space-between;
        flex-direction: row;
        gap: 24px;
    }

    .navbar-search{
        margin: 0;
        width: 315px;
    }

    .search-title{
        display: flex;
        align-items: center;
        justify-content: left;
        width: 100%;
        height: fit-content;
        background-color: var(--main-white);
        border-radius: 16px;
        outline: 1px var(--orange-my) solid;
        color: var(--green-dark);
        gap: 8px;
        font-size: 14px;
        font-weight: 500;
        line-height: 21px;
        padding: 10px 12px;
        text-align: center;
        cursor: pointer;
        text-decoration: none;
        transition: background-color 0.5s ease, color 0.5s ease;
        margin: 0;
    }

    .search{
        padding: 0;
        font-size: 14px;
        font-weight: 500;
        line-height: 21px;
    }

    .search::placeholder {
        color: var(--greey-my);
    }

    .buttons{
        display: flex;
        height: fit-content;
        align-items: center;
        justify-content: flex-end;
        flex-direction: row;
        gap: 16px;
    }

    .button-add-application{
        display: flex;
        align-items: center;
        justify-content: center;
        width: auto;
        height: fit-content;
        background-color: var(--green-light);
        border-radius: 16px;
        color: var(--main-white);
        gap: 8px;
        font-size: 14px;
        font-weight: 500;
        line-height: 21px;
        padding: 10px 12px;
        text-align: center;
        cursor: pointer;
        text-decoration: none;
        transition: background-color 0.5s ease, color 0.5s ease;
    }

    .button-report{
        display: flex;
        align-items: center;
        justify-content: center;
        width: max-content;
        height: fit-content;
        background-color: var(--yellow-my);
        border-radius: 16px;
        border: 1px var(--main-green-dark) solid;
        color: var(--main-green-dark);
        gap: 8px;
        font-size: 14px;
        font-weight: 500;
        line-height: 21px;
        padding: 10px 12px;
        text-align: center;
        cursor: pointer;
        text-decoration: none;
        transition: background-color 0.5s ease, color 0.5s ease;
    }

    .filter-bar{
        width: 100%;
        height: fit-content;
        display: inline-flex;
        justify-content: space-between;
        flex-direction: row;
        gap: 24px;
    }

    .sort-filter-block{
        width: fit-content;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: row;
        gap: 6px;
        border-radius: 16px;
        padding: 0 16px;
        background-color: var(--white-my);
        box-shadow: 2px 2px 6px rgba(83, 47, 4, 0.25);
    }

    .label-sort-filter{
        margin: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        width: fit-content;
        height: fit-content;
        color: var(--main-green-dark);
        gap: 8px;
        font-size: 14px;
        font-weight: 500;
        line-height: 21px;
        padding: 12px 12px;
        border-right: 1px solid var(--orange-my);


    }

    .sort-select{
        padding: 12px 16px;
        margin: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        color: var(--greey-my);
    }

    .sort-input{
        width: 180px;
        border: none;

        color: var(--greey-my);
        font-size: 14px;
        font-weight: 500;
        line-height: 21px;
    }

    .button-reset{
        margin: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        width: fit-content;
        height: fit-content;
        color: var(--orange-my);
        gap: 8px;
        font-size: 14px;
        font-weight: 500;
        line-height: 21px;
        padding: 12px 12px;
        border: none;
        background-color: transparent;
    }

    .application-block{
        width: 100%;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 36px;
        padding: 64px 80px;
    }

    @media (max-width: 768px) {

        .application-block{
            gap: 12px;
            padding: 24px;
        }
    }


</style>
