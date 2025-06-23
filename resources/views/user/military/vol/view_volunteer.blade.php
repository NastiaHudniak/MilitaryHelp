@extends('layouts.app')
@include('layouts.header_military')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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
                    <button id="filter-known" type="button" class="button-filter">Знайомі</button>
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
                            <option value="rating">За рейтингом</option>
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

        <div class="volunteer-block" id="volunteer-card-container">
            @foreach ($volunteers as $volunteer)
                <div class="card-volunteer">
                    <div class="card-foto">
                        @if(count($volunteer->images) > 0)
                            <img src="{{ asset('storage/' . $volunteer->images[0]->image_url) }}" alt="User Image"  style="border-radius: 500px;">
                        @else
                            <img src="{{ asset('images/acc.jpg') }}" alt="User Image"  style=" border-radius: 50px;">
                        @endif
                    </div>
                    <div class="card-header-app">
                        <h5 class="card-title-app">{{ $volunteer->name }} {{ $volunteer->surname }}</h5>
                        <div class="star-rating">
                            @for($i = 1; $i <= 5; $i++)
                                <div class="star">
                                    @if($volunteer->average_rating >= $i)
                                        <!-- Повністю заповнена зірочка -->
                                        <div class="full"></div>
                                    @elseif($volunteer->average_rating >= $i - 0.5 && $volunteer->average_rating < $i)
                                        <!-- Половинно заповнена зірочка -->
                                        <div class="half"></div>
                                    @else
                                        <!-- Порожня зірочка -->
                                        <div class="empty"></div>
                                    @endif
                                </div>
                            @endfor
                            <p>{{ number_format($volunteer->average_rating, 1) }}</p>
                        </div>
                    </div>
                    <div class="buttons-blocks">
                        <button class="favorite-btn" type="button" data-id="{{ $volunteer->id }}">
                            <img src="{{ auth()->user()->favorites->contains($volunteer->id) ? asset('images/icon/bookmarks/bookmark-filled.svg') : asset('images/icon/bookmarks/bookmark.svg') }}"
                                 alt="Favorite"
                                 class="favorite-icon"
                                 data-outline="{{ asset('images/icon/bookmarks/bookmark.svg') }}"
                                 data-filled="{{ asset('images/icon/bookmarks/bookmark-filled.svg') }}">
                        </button>
                        <a href="" class="button-view-info" data-toggle="modal" data-target="#applicationModal{{ $volunteer->id }}">
                            Детальніше
                            <img src="{{ asset('images/icon/info.svg') }}">
                        </a>
                    </div>
                </div>
            @endforeach
                @foreach ($volunteers as $volunteer)
                    <div class="modal" id="applicationModal{{ $volunteer->id }}" tabindex="-1" aria-labelledby="applicationModalLabel{{ $volunteer->id }}"  aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false"  style="top: 10%; left: 30%;">
                        <div class="modal-info-block">
                            <div class="modal-status-close">
                                <div class="modal-title" id="applicationModalLabel{{ $volunteer->id }}">
                                    <p class="info-title">{{ $volunteer->name }} {{ $volunteer->surname }}</p>
                                </div>
                                <button type="button" class="close-button" data-dismiss="modal" aria-label="Close">
                                    <img src="{{ asset('images/icon/cancell.svg') }}">
                                </button>
                            </div>
                            <div class="modal-foto-text">
                                <div class="modal-foto">
                                    @if(count($volunteer->images) > 0)
                                        <img src="{{ asset('storage/' . $volunteer->images[0]->image_url) }}" alt="User Image"  style="border-radius: 500px;">
                                    @else
                                        <img src="{{ asset('images/acc.jpg') }}" alt="User Image"  style=" border-radius: 50px;">
                                    @endif
                                </div>
                                <div class="modal-description">
                                    <p class="info-description">{{ $volunteer->email }}</p>
                                    <p class="info-description">{{ $volunteer->phone }}</p>
                                    <p class="info-description">{{ $volunteer->address }}</p>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <div class="star-rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        <div class="star">
                                            @if($volunteer->average_rating >= $i)
                                                <!-- Повністю заповнена зірочка -->
                                                <div class="full"></div>
                                            @elseif($volunteer->average_rating >= $i - 0.5 && $volunteer->average_rating < $i)
                                                <!-- Половинно заповнена зірочка -->
                                                <div class="half"></div>
                                            @else
                                                <!-- Порожня зірочка -->
                                                <div class="empty"></div>
                                            @endif
                                        </div>
                                    @endfor
                                    <p>{{ number_format($volunteer->average_rating, 1) }}</p>
                                </div>
                                <button class="favorite-btn" type="button" data-id="{{ $volunteer->id }}">
                                    <img src="{{ auth()->user()->favorites->contains($volunteer->id) ? asset('images/icon/bookmarks/bookmark-filled.svg') : asset('images/icon/bookmarks/bookmark.svg') }}"
                                         alt="Favorite"
                                         class="favorite-icon"
                                         data-outline="{{ asset('images/icon/bookmarks/bookmark.svg') }}"
                                         data-filled="{{ asset('images/icon/bookmarks/bookmark-filled.svg') }}">
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach

        </div>
    </div>

    <script>

        document.addEventListener("DOMContentLoaded", function () {
            // --- Початкові змінні ---
            const searchInput = document.getElementById('search');
            const filterFavoritesBtn = document.getElementById('filter-favorites');
            const filterKnownBtn = document.getElementById('filter-known');
            const filterAllBtn = document.getElementById('filter-all');
            const sortSelect = document.getElementById('sort-filter');
            const cardContainer = document.getElementById('volunteer-card-container');
            const noResults = document.getElementById('no-results');
            const resetFiltersBtn = document.getElementById('reset-filters');

            let currentFilter = ''; // '', 'favorites', 'known'
            let currentSort = '';
            let currentQuery = '';
            let searchTimeout;
            function initFavoriteButtons() {
                document.querySelectorAll('.favorite-btn').forEach(btn => {
                    btn.onclick = function () {
                        const volunteerId = this.dataset.id;
                        const icon = this.querySelector('img');
                        const outlineSrc = icon.dataset.outline;
                        const filledSrc = icon.dataset.filled;

                        console.log('Натиснули на favorite-btn, ID:', volunteerId);

                        fetch(`/users/${volunteerId}/favorite`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({})
                        })
                            .then(response => {
                                if (!response.ok) throw new Error('Network response was not ok');
                                return response.json();
                            })
                            .then(data => {
                                console.log('Відповідь сервера:', data);

                                if (data.status === 'added') {
                                    icon.src = filledSrc + '?' + new Date().getTime();
                                    showToast('Волонтер доданий в обране', 'success');
                                } else if (data.status === 'removed') {
                                    icon.src = outlineSrc + '?' + new Date().getTime();
                                    showToast('Волонтер видалений з обраного', 'success');
                                }
                            })
                            .catch(error => {
                                console.error('Помилка:', error);
                                showToast('Сталася помилка. Спробуйте ще раз.', 'error');
                            });
                    };
                });
            }
            function fetchVolunteers() {
                const url = `{{ route('user.military.vol.search') }}?` +
                    new URLSearchParams({
                        query: currentQuery,
                        filter: currentFilter,
                        sort: currentSort
                    }).toString();
                showLoaderWithDelay();
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        cardContainer.innerHTML = '';
                        // Спочатку видаляємо старі модалки
                        document.querySelectorAll('.modal.dynamic-modal').forEach(modal => modal.remove());

                        if (data.volunteers.length === 0) {
                            if (noResults) noResults.style.display = 'block';
                            return;
                        } else {
                            if (noResults) noResults.style.display = 'none';
                        }

                        data.volunteers.forEach(volunteer => {
                            const avgRating = volunteer.average_rating ? volunteer.average_rating.toFixed(1) : '0.0';
                            const imgSrc = volunteer.images.length > 0
                                ? `{{ asset('storage') }}/${volunteer.images[0].image_url}`
                                : `{{ asset('images/acc.jpg') }}`;

                            const isFavorite = volunteer.is_favorite;
                            const outlineSrc = `{{ asset('images/icon/bookmarks/bookmark.svg') }}`;
                            const filledSrc = `{{ asset('images/icon/bookmarks/bookmark-filled.svg') }}`;
                            const favoriteImg = isFavorite ? filledSrc : outlineSrc;

                            function getStarHTML(index) {
                                if (volunteer.average_rating >= index) return `<div class="full"></div>`;
                                else if (volunteer.average_rating >= index - 0.5) return `<div class="half"></div>`;
                                else return `<div class="empty"></div>`;
                            }

                            let starsHTML = '';
                            for (let i = 1; i <= 5; i++) {
                                starsHTML += `<div class="star">${getStarHTML(i)}</div>`;
                            }

                            const card = document.createElement('div');
                            card.className = 'card-volunteer';
                            card.innerHTML = `
                    <div class="card-foto">
                        <img src="${imgSrc}" alt="User Image" style="border-radius: 50%;">
                    </div>
                    <div class="card-header-app">
                        <h5 class="card-title-app">${volunteer.name} ${volunteer.surname}</h5>
                        <div class="star-rating">${starsHTML}<p>${avgRating}</p></div>
                    </div>
                    <div class="buttons-blocks">
                        <button class="favorite-btn" type="button" data-id="${volunteer.id}">
                            <img src="${favoriteImg}"
                                alt="Favorite"
                                class="favorite-icon"
                                data-outline="${outlineSrc}"
                                data-filled="${filledSrc}">
                        </button>
                        <a href="javascript:void(0);" class="button-view-info" data-toggle="modal" data-target="#applicationModal${volunteer.id}">
                            Детальніше
                            <img src="{{ asset('images/icon/info.svg') }}">
                        </a>
                    </div>
                `;
                            cardContainer.appendChild(card);

                            // Додати відповідну модалку в кінець body
                            const modalHTML = `
                    <div class="modal fade dynamic-modal" id="applicationModal${volunteer.id}" tabindex="-1"
     aria-labelledby="applicationModalLabel${volunteer.id}" aria-hidden="true"
     data-backdrop="static" data-keyboard="false" style="top: 10%; left: 30%;">

    <div class="modal-info-block">
        <div class="modal-status-close">
            <div class="modal-title" id="applicationModalLabel${volunteer.id}">
                <p class="info-title">${volunteer.name} ${volunteer.surname}</p>
            </div>
            <button type="button" class="close-button" data-dismiss="modal" aria-label="Close">
                <img src="/images/icon/cancell.svg">
            </button>
        </div>
        <div class="modal-foto-text">
            <div class="modal-foto">
                <img src="${imgSrc}" alt="User Image" style="border-radius: 500px;">
            </div>
            <div class="modal-description">
                <p class="info-description">${volunteer.email}</p>
                <p class="info-description">${volunteer.phone}</p>
                <p class="info-description">${volunteer.address}</p>
            </div>
        </div>

        <div class="modal-footer">
            <div class="star-rating">
                ${starsHTML}
                <p>${avgRating}</p>
            </div>
            <button class="favorite-btn" type="button" data-id="${volunteer.id}">
                <img src="${favoriteImg}"
                     alt="Favorite"
                     class="favorite-icon"
                     data-outline="${outlineSrc}"
                     data-filled="${filledSrc}">
            </button>
        </div>
    </div>
</div>
                `;
                            document.body.insertAdjacentHTML('beforeend', modalHTML);
                        });

                        initFavoriteButtons();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    })
                    .finally(() => {
                        setTimeout(() => {
                            hideLoader();
                        }, 100);
                    });
            }


            searchInput.addEventListener('input', e => {
                clearTimeout(searchTimeout);
                currentQuery = e.target.value;
                searchTimeout = setTimeout(fetchVolunteers, 1000);

            });

            filterFavoritesBtn.addEventListener('click', () => {
                currentFilter = 'favorites';
                setActiveFilterButton(filterFavoritesBtn);
                fetchVolunteers();
            });

            filterKnownBtn.addEventListener('click', () => {
                currentFilter = 'known';
                setActiveFilterButton(filterKnownBtn);
                fetchVolunteers();
            });

            filterAllBtn.addEventListener('click', () => {
                currentFilter = '';
                setActiveFilterButton(filterAllBtn);
                fetchVolunteers();
            });

            sortSelect.addEventListener('change', e => {
                currentSort = e.target.value;
                fetchVolunteers();
            });

            function setActiveFilterButton(activeBtn) {
                [filterFavoritesBtn, filterKnownBtn, filterAllBtn].forEach(btn => btn.classList.remove('active'));
                activeBtn.classList.add('active');
            }
            resetFiltersBtn.addEventListener('click', () => {
                // Очистити всі поля
                searchInput.value = '';
                currentQuery = '';

                currentFilter = '';
                setActiveFilterButton(filterAllBtn);

                currentSort = '';
                sortSelect.value = '';

                fetchVolunteers();
            });
            // 🔥 Початкове завантаження
            fetchVolunteers();
        });

        function toggleFilters() {
            const block = document.getElementById('filtersBlock');
            block.classList.toggle('open');
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            if (modal) {
                modal.style.display = 'none';
                modal.classList.remove('show');
            }

            // Видаляємо backdrop
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) {
                backdrop.remove();
            }

            // Опціонально прибрати scroll lock
            document.body.classList.remove('modal-open');
            document.body.style.overflow = ''; // Bootstrap додає overflow:hidden
        }
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

    .volunteer-block{
        width: 100%;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 36px;
        padding: 64px 80px;
    }

    @media (max-width: 768px) {

        .volunteer-block{
            gap: 12px;
            padding: 24px;
        }
    }


    .card-volunteer{
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

    .star-rating{
        display: flex;
        flex-direction: row;
        gap: 4px;
        align-items: center;
        justify-content: center;
        color: var(--green-dark);
        font-size: 18px;
        font-weight: 400;
        word-wrap: break-word;
        margin: 0;
    }

    .star-rating p{
        margin: 0;
    }

    .star {
        display: inline-block;
        width: 20px;
        height: 20px;
        margin-right: 3px;
        position: relative;
        background: transparent;
    }

    .star .full {
        border: 2px solid var(--orange-my);
        background-color: var(--orange-my);
        width: 100%;
        height: 100%;
        clip-path: polygon(50% 0%, 61% 35%, 98% 35%, 68% 57%, 79% 91%, 50% 70%, 21% 91%, 32% 57%, 2% 35%, 39% 35%);
        border-radius: 4px;
        box-shadow: 0 0 0 2px var(--orange-my);
    }

    .star .half {
        border: 2px solid var(--orange-my);
        background: linear-gradient(90deg, var(--orange-my) 50%, var(--blue-my) 50%);
        width: 100%;
        height: 100%;
        clip-path: polygon(50% 0%, 61% 35%, 98% 35%, 68% 57%, 79% 91%, 50% 70%, 21% 91%, 32% 57%, 2% 35%, 39% 35%);
        border-radius: 4px;
        box-shadow: 0 0 0 2px var(--orange-my);
    }

    .star .empty {
        background-color: var(--blue-my);
        border: 2px solid var(--orange-my);
        width: 100%;
        height: 100%;
        clip-path: polygon(50% 0%, 61% 35%, 98% 35%, 68% 57%, 79% 91%, 50% 70%, 21% 91%, 32% 57%, 2% 35%, 39% 35%);
        border-radius: 4px;
        box-shadow: 0 0 0 2px var(--orange-my);
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

        .card-volunteer{
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
