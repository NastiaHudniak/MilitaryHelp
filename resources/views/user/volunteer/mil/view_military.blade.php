@extends('layouts.app')
@include('layouts.header_volunteer')

@section('content')
    <div class="main-content" style="font-family: 'Open Sans', sans-serif;">
        <button class="filters-toggle-btn" onclick="toggleFilters()">Фільтри</button>
        <div class="filters-blocks" id="filtersBlock" style="margin-bottom: 20px;">
            <div class="navigation-bar">
                <nav class="navbar-search">
                    <div class="search-title">
                        <img src="{{ asset('images/icon/search.svg') }}" alt="search icon">
                        <input type="text" id="search" class="search" placeholder="Пошук за ім'ям або прізвищем" style="width: 250px;">
                    </div>
                </nav>
                <div class="buttons">
                    <button id="filter-favorites" type="button" class="button-filter">Обрані</button>
                    <button id="filter-all" type="button" class="button-filter active">Всі</button>
                </div>
            </div>

            <div class="filter-bar">
                <div class="sort-filter-block">
                    <label for="sort-filter" class="label-sort-filter">
                        <img src="{{ asset('images/icon/sort.svg') }}" alt="Sort icon">
                        Сортування за:
                    </label>
                    <div class="sort-select">
                        <select id="sort-filter" class="sort-input">
                            <option value="">Виберіть сортування</option>
                            <option value="alphabet">За алфавітом (ім'я)</option>
                            <option value="favorites_first">Спочатку обрані</option>
                        </select>
                    </div>
                </div>

                <div class="sort-filter-block">
                    <button id="reset-filters" class="button-reset" type="button">
                        <img src="{{ asset('images/icon/reset.svg') }}" alt="Reset icon">
                        Скинути фільтр
                    </button>
                </div>
            </div>
        </div>
        <div id="no-results" class="not-found" style="display: none; text-align: center;">
            <div class="not-found-block" style="display: flex; text-align: center; flex-direction: column; gap: 10px;">

                <div class="not-found-image">
                    <img src="{{ asset('images/logo/not-found.svg') }}" style="width: 350px; height: auto">
                </div>
                <div class="not-found-text" style="color: var(--orange-my); font-size: 32px; font-weight: bold">
                    Нажаль за вашим запитом нічого не знайдено(
                </div>
            </div>

        </div>

        <div class="military-block" id="military-card-container">
            @foreach ($militaries as $military)
                <div class="card-military">
                    <div class="card-foto">
                        @if(count($military->images) > 0)
                            <img src="{{ asset('storage/' . $military->images[0]->image_url) }}" alt="User Image"  style="width:70px; height:70px; border-radius: 50px;">
                        @else
                            <img src="{{ asset('images/acc.jpg') }}" alt="User Image"  style="width:70px; height:70px; border-radius: 50px; border-radius: 50px;">
                        @endif
                    </div>
                    <div class="card-header-app">
                        <h5 class="card-title-app">{{ $military->name }} {{ $military->surname }}</h5>
                    </div>
                    <div class="buttons-blocks">
                        <button class="favorite-btn" type="button" data-id="{{ $military->id }}">
                            <img src="{{ auth()->user()->favorites->contains($military->id) ? asset('images/icon/bookmarks/bookmark-filled.svg') : asset('images/icon/bookmarks/bookmark.svg') }}"
                                 alt="Favorite"
                                 class="favorite-icon"
                                 data-outline="{{ asset('images/icon/bookmarks/bookmark.svg') }}"
                                 data-filled="{{ asset('images/icon/bookmarks/bookmark-filled.svg') }}">
                        </button>
                        <a href="{{ route('user.volunteer.view_info_military', $military->id) }}" class="button-view-info">
                            Детальніше
                            <img src="{{ asset('images/icon/info.svg') }}">
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const searchInput = document.getElementById('search');
            const filterFavoritesBtn = document.getElementById('filter-favorites');
            const filterAllBtn = document.getElementById('filter-all');
            const sortSelect = document.getElementById('sort-filter');
            const cardContainer = document.getElementById('military-card-container');
            const resetFiltersBtn = document.getElementById('reset-filters');

            let currentFilter = ''; // '', 'favorites'
            let currentSort = '';
            let currentQuery = '';

            function initFavoriteButtons() {
                document.querySelectorAll('.favorite-btn .favorite-icon').forEach(function (icon) {
                    icon.addEventListener('click', function (e) {
                        e.stopPropagation();
                        const btn = icon.closest('.favorite-btn');
                        const userId = btn.dataset.id;
                        const outlineSrc = icon.dataset.outline;
                        const filledSrc = icon.dataset.filled;

                        fetch(`/users/${userId}/favorite`, {
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
                                        alert('Будь ласка, увійдіть, щоб додати в обрані');
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
                                    btn.classList.add('favorited');
                                    showToast('Військовий доданий в обране', 'success');
                                } else if (data.status === 'removed') {
                                    icon.setAttribute('src', outlineSrc);
                                    btn.classList.remove('favorited');
                                    showToast('Військовий видалений з обраного', 'success');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                showToast('Сталася помилка. Спробуйте ще раз.', 'error');
                            });
                    });
                });
            }
            function fetchMilitaries() {
                const url = `{{ route('user.volunteer.mil.search') }}?` + new URLSearchParams({
                    query: currentQuery,
                    filter: currentFilter,
                    sort: currentSort
                }).toString();

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        const militaries = data.militaries || data.$militaries || [];

                        cardContainer.innerHTML = '';

                        if (militaries.length === 0) {
                            cardContainer.innerHTML = '<p style="text-align:center; width:100%">Нічого не знайдено</p>';
                            return;
                        }

                        militaries.forEach(military => {
                            const imgSrc = (military.images.length > 0)
                                ? `{{ asset('storage') }}/${military.images[0].image_url}`
                                : `{{ asset('images/acc.jpg') }}`;

                            const isFavorite = military.is_favorite
                                ? '{{ asset('images/icon/bookmarks/bookmark-filled.svg') }}'
                                : '{{ asset('images/icon/bookmarks/bookmark.svg') }}';

                            const card = document.createElement('div');
                            card.className = 'card-military';
                            card.innerHTML = `
                            <div class="card-foto">
                                <img src="${imgSrc}" alt="User Image" style="width:70px; height:70px; border-radius: 50px;">
                            </div>
                            <div class="card-header-app">
                                <h5 class="card-title-app">${military.name} ${military.surname}</h5>
                            </div>
                            <div class="buttons-blocks">
                                <button class="favorite-btn" type="button" data-id="${military.id}">
                                    <img src="${isFavorite}"
                                         alt="Favorite"
                                         class="favorite-icon"
                                         data-outline="{{ asset('images/icon/bookmarks/bookmark.svg') }}"
                                         data-filled="{{ asset('images/icon/bookmarks/bookmark-filled.svg') }}">
                                </button>
                                <a href="/volunteer/view_info_military/${military.id}" class="button-view-info">
                                    Детальніше
                                    <img src="{{ asset('images/icon/info.svg') }}">
                                </a>
                            </div>
                        `;
                            cardContainer.appendChild(card);
                        });

                        initFavoriteButtons();
                    })
                    .catch(error => console.error('Error:', error));
            }

            function setActiveFilterButton(activeBtn) {
                [filterFavoritesBtn, filterAllBtn].forEach(btn => btn.classList.remove('active'));
                activeBtn.classList.add('active');
            }

            // --- Event listeners ---
            searchInput.addEventListener('input', e => {
                currentQuery = e.target.value;
                fetchMilitaries();
            });

            filterFavoritesBtn.addEventListener('click', () => {
                currentFilter = 'favorites';
                setActiveFilterButton(filterFavoritesBtn);
                fetchMilitaries();
            });

            filterAllBtn.addEventListener('click', () => {
                currentFilter = '';
                setActiveFilterButton(filterAllBtn);
                fetchMilitaries();
            });

            sortSelect.addEventListener('change', e => {
                currentSort = e.target.value;
                fetchMilitaries();
            });

            resetFiltersBtn.addEventListener('click', () => {
                searchInput.value = '';
                currentQuery = '';

                currentFilter = '';
                setActiveFilterButton(filterAllBtn);

                currentSort = '';
                sortSelect.value = '';

                fetchMilitaries();
            });



            // Запуск при завантаженні сторінки
            fetchMilitaries();
        });

        function initFavoriteButtons() {
            document.querySelectorAll('.favorite-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');
                    const icon = this.querySelector('.favorite-icon');
                    const isFilled = icon.getAttribute('src') === icon.dataset.filled;

                    fetch(`/favorites/toggle/${id}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        }
                    })
                        .then(response => {
                            if (!response.ok) throw new Error('Не вдалося змінити обране');
                            // toggle icon
                            icon.setAttribute('src', isFilled ? icon.dataset.outline : icon.dataset.filled);
                        })
                        .catch(error => console.error(error));
                });
            });
        }

        function toggleFilters() {
            const block = document.getElementById('filtersBlock');
            block.classList.toggle('open');
        }
    </script>





    <script>

function fetchVolunteers(query) {
    const url = `{{ route('user.volunteer.mil.search') }}?query=${encodeURIComponent(query)}`;
    console.log(url);
    fetch(url)
        .then(response => response.json())
        .then(data => {
            const cardContainer = document.getElementById('volunteer-card-container');
            const noResults = document.getElementById('no-results');
            cardContainer.innerHTML = '';

            if (data.volunteers.length === 0) {
                noResults.style.display = 'block';
            } else {
                noResults.style.display = 'none';
                    data.volunteers.forEach(military => {
                        const card = document.createElement('div');
                         card.className = 'col-md-3 mb-4';
                         card.innerHTML = `
                            <div class="card h-100">
                                <div class="card-header" style="background-color: var(--green-400);">
                                    <div class="image-scroll-container mb-3" style="overflow-x: auto; white-space: nowrap; padding-bottom: 10px;">
                                    ${military.images.map(image => `
                                        <img src="${'{{ asset('storage/') }}' + '/' + image.image_url}" alt="User Image" class="img-fluid" style="width:70px; height:70px; object-fit: cover; display: inline-block; margin-right: 10px; border-radius: 50px;">
                                    `).join('')}
                                </div>
                                </div>
                             <div class="card-body" style="background-color: var(--green-300); color: var(--green-800);">
                                <h5 class="card-title" style="color: var(--green-800);">${military.name}</h5>
                                    <h5 class="card-title" style="color: var(--green-800);">${military.surname}</h5>
                            </div>
                            <div class="card-footer" style="background-color: var(--green-200);">
                                <a href="/user/volunteer/view_info_military/${military.id}" class="btn btn-sm" style="color: var(--green-500);">
                                    <i class="fas fa-eye"></i> Переглянути
                                </a>
                            </div>
                            </div>
                            `;
                            cardContainer.appendChild(card);
                });
            }
                })
                .catch(error => console.error('Error:', error));
        }


        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.favorite-btn .favorite-icon').forEach(function (icon) {
                icon.addEventListener('click', function (e) {
                    e.stopPropagation();
                    const btn = icon.closest('.favorite-btn');
                    const userId = btn.dataset.id;
                    const outlineSrc = icon.dataset.outline;
                    const filledSrc = icon.dataset.filled;

                    fetch(`/users/${userId}/favorite`, {
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
                                    alert('Будь ласка, увійдіть, щоб додати в обрані');
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
                                btn.classList.add('favorited');
                                showToast('Військовий доданий в обране', 'success');
                            } else if (data.status === 'removed') {
                                icon.setAttribute('src', outlineSrc);
                                btn.classList.remove('favorited');
                                showToast('Військовий видалений з обраного', 'success');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showToast('Сталася помилка. Спробуйте ще раз.', 'error');
                        });
                });
            });
        });
    </script>
    @include('layouts.footer')
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

    .military-block{
        width: 100%;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 36px;
        padding: 64px 80px;
    }

    @media (max-width: 768px) {

        .military-block{
            gap: 12px;
            padding: 24px;
        }
    }


    .card-military{
        width: calc(25% - 27px);
        display: flex;
        justify-content: flex-end;
        align-items: center;
        flex-direction: column;
        padding: 16px;
        gap: 24px;
        background-color: var(--yellow-my);
        border-radius: 16px;
    }

    .card-foto{
        padding: 0;
    }
    .card-foto img{
        padding: 0;
        width: 120px;
        height: 120px;
    }

    .card-header-app{
        display: flex;
        justify-content: flex-start;
        align-items: center;
        flex-direction: column;
        gap: 0;
        background-color: transparent; !important;
        border: none; !important;

    }

    .card-title-app {
        color: var(--black-my);
        font-size: 20px;
        font-weight: 600;
        line-height: 130%;
        word-wrap: break-word;
        margin: 0;
    }


    .buttons-blocks{
        width: 100%;
        display: flex;
        justify-content: space-between;
        padding: 0;
        background-color: transparent;
        border: none;
    }

    .button-view-info{
        display: flex;
        align-items: center;
        justify-content: center;
        width: auto;
        height: fit-content;
        background-color: var(--yellow-my);
        border-radius: 16px;
        border: 1px var(--main-green-dark) solid;
        color: var(--main-green-dark);
        gap: 8px;
        font-size: 14px;
        font-weight: 500;
        line-height: 130%;
        padding: 6px 16px;
        text-align: center;
        cursor: pointer;
        text-decoration: none;
        transition: background-color 0.5s ease, color 0.5s ease;
    }

    .favorite-btn {
        background: none;
        border: none;
        padding: 0;
        margin: 0;
        outline: none;
        cursor: pointer;
        appearance: none;
    }

    .favorite-btn:focus,
    .favorite-btn:active {
        outline: none;
        box-shadow: none;
    }

    .favorite-icon {
        width: 32px;
        height: 32px;
        display: block;
    }






    .modal-status-close{
        display: flex;
        justify-content: space-between;
        flex-direction: row;
        padding: 0;
        margin: 0;

    }

    .modal-info-block{
        width: 40%;
        display: flex;
        justify-content: start;
        flex-direction: column;
        gap: 24px;
        border-radius: 16px;
        padding: 24px;
        background-color: var(--main-white);
    }


    .close-button{
        padding: 0;
        margin: 0;
        background-color: transparent;
        border: none;
    }

    .modal-foto-text{
        display: flex;
        justify-content: start;
        flex-direction: row;
        gap: 32px;
    }

    .modal-foto{
        padding: 0;
    }
    .modal-foto img{
        padding: 0;
        width: 180px;
        height: 180px;
    }



    .modal-title, .modal-description{
        display: flex;
        justify-content: start;
        flex-direction: column;
        gap: 8px;

    }

    .info-title{
        color: var(--black-my);
        font-size: 20px;
        font-weight: 600;
        line-height: 130%;
        word-wrap: break-word;
        margin: 0;
    }

    .info-description{
        color: var(--green-dark);
        font-size: 18px;
        font-weight: 400;
        line-height: 130%;
        word-wrap: break-word;
        margin: 0;
    }

    .modal-foto{
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-direction: row;
        gap: 16px;
    }


    .modal-footer{
        width: 100%;
        display: flex;
        align-items: start;
        justify-content: start;
        flex-direction: row;
        gap: 16px;
    }

    @media (max-width: 768px) {

        .card-military{
            width: calc(50% - 12px);
            gap: 12px;
        }

        .card-title-app {
            font-size: 16px;
        }


        .buttons-blocks{
            display: flex;
            flex-direction: column;
            align-items: start;
            gap: 8px;
        }

        .modal {
            top: 5% !important;
            left: 5% !important;
            right: 5% !important;
            width: 90% !important;
            margin: 0 auto;
            padding: 0;
        }

        .modal-info-block {
            width: 100% !important;
            max-height: 90vh;
            overflow-y: auto;
            padding: 16px;
            box-sizing: border-box;
        }

        .modal-foto img{
            padding: 0;
            width: 110px;
            height: 110px;
        }

        .modal-status-close{
            display: flex;
            justify-content: space-between;
            flex-direction: row;
            padding: 0;
            margin: 0;

        }



        .modal-title, .modal-description{
            display: flex;
            justify-content: start;
            flex-direction: column;
            gap: 0;

        }

        .info-title{
            font-size: 18px;
        }

        .info-description{
            font-size: 14px;
        }


        .modal-footer{
            width: 100%;
            display: flex;
            align-items: start;
            justify-content: space-between !important;
            flex-direction: row;
            gap: 16px;
        }

    }


    .filters-toggle-btn {
        display: none;
        width: 100%;
        padding: 12px;
        background-color: var(--green-light);
        color: white;
        font-weight: bold;
        font-size: 16px;
        border: none;
        cursor: pointer;
        margin-bottom: 10px;
        border-radius: 8px;
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
        text-decoration: none;
        border: none;
    }
    .search,
    button {
        border: none;
        outline: none;
        box-shadow: none;
        text-decoration: none;
    }

    .search:focus,
    button:focus,
    .search:focus-visible,
    button:focus-visible,
    .search:active,
    button:active {
        border: none !important;
        outline: none !important;
        box-shadow: none !important;
        text-decoration: none !important;
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

    .button-filter{
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

    @media screen and (max-width: 768px) {
        /* Ховаємо блок фільтрів за замовчуванням */
        .filters-blocks {
            display: none;
            flex-direction: column;
            gap: 12px;
            padding: 10px;
            background-color: #f7f7f7;
            border-radius: 8px;
            margin-bottom: 20px;
            overflow-y: auto;
        }

        .filters-blocks.open {
            display: flex;
        }

        .filters-toggle-btn {
            display: block;
        }
    }
</style>
