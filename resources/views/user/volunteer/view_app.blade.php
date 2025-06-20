@extends('layouts.app')
@include('layouts.header_volunteer')
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')


    <div class="main-content" style="font-family: 'Open Sans', sans-serif;">

        <button class="filters-toggle-btn" onclick="toggleFilters()">Фільтри</button>

        <div class="filters-blocks" id="filtersBlock">
            <div class="navigation-bar">
                <nav class="navbar-search">
                    <div class="search-title">
                        <img src="{{ asset('images/icon/search.svg') }}" >
                        <input type="text" class="search" id="search" placeholder="Пошук за назвою">
                    </div>
                </nav>
                <div class="buttons">
                    <a href="#"
                       class="button-report generate-all-pdf"
                       data-url="{{ route('user.volunteer.exportAllPDF') }}">
                        <img src="{{ asset('images/icon/pdf.svg') }}">
                        Сформувати звіт в .pdf
                    </a>
                    <a type="submit" class="button-report">
                        <img src="{{ asset('images/icon/excel.svg') }}" >
                        Сформувати звіт в .xslx
                    </a>



                </div>
            </div>
            <div class="filter-bar">
                <div class="sort-filter-block">
                    <label for="application-sort-filter" class="label-sort-filter">
                        <img src="{{ asset('images/icon/sort.svg') }}">
                        Сортування за:
                    </label>
                    <div class="sort-select" >
                        <select id="sort-filter" class="sort-input">
                            <option value="urgent_oldest">Термінові + старіші</option>
                            <option value="oldest">Старіші → новіші</option>
                            <option value="newest">Новіші → старіші</option>
                            <option value="title">За назвою</option>
                        </select>

                    </div>
                </div>
                <button id="filter-term" type="button" class="button-filter">Термінові</button>

                <div class="sort-filter-block">
                    <label for="application-sort-filter" class="label-sort-filter">
                        <img src="{{ asset('images/icon/filter.svg') }}">
                        Фільтр за:
                    </label>
                    <div class="sort-select" style="border-right: 1px solid var(--orange-my);">
                        <select id="category-filter" class="sort-input" >
                            <option value="">Усі заявки</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="sort-select" style="border-right: 1px solid var(--orange-my);">
                        <select id="status-filter" class="sort-input">
                            <option value="">Усі статуси</option>
                            <option value="created">створено</option>
                            <option value="accept">прийнято</option>
                            <option value="cancel">відхилено</option>
                        </select>
                    </div>
                    <button id="reset-filter" class="button-reset" type="button">
                        <img src="{{ asset('images/icon/reset.svg') }}">
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

        <div class="application-block" id="application-card-container">
            @foreach ($applications as $application)
                @include('components.application-card-vol', ['application' => $application])
            @endforeach
        </div>

    </div>


     @include('layouts.footer')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('search');
            const sortSelect = document.getElementById('sort-filter');
            const filterTermBtn = document.getElementById('filter-term');
            const categorySelect = document.getElementById('category-filter');
            const statusSelect = document.getElementById('status-filter');
            const resetBtn = document.getElementById('reset-filter');
            const container = document.getElementById('application-card-container');
            const noResults = document.getElementById('no-results');

            let urgentFilterActive = false;

            function fetchApplications() {
                const search = searchInput.value;
                const sort = sortSelect.value;
                const category = categorySelect.value;
                const status = statusSelect.value;
                const urgent = urgentFilterActive ? 'true' : '';

                const url = new URL("{{ route('user.volunteer.filteredApplications') }}", window.location.origin);
                if (search) url.searchParams.append('search', search);
                if (sort) url.searchParams.append('sort', sort);
                if (category) url.searchParams.append('category', category);
                if (status) url.searchParams.append('status', status);
                if (urgent) url.searchParams.append('urgent', urgent);

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        container.innerHTML = data.html;
                        if (data.html.trim() === '') {
                            noResults.style.display = 'block';
                        } else {
                            noResults.style.display = 'none';
                        }
                        initLikeButtons(); // <-- Ініціалізація лайків після оновлення DOM
                    })
                    .catch(error => {
                        console.error('Помилка під час завантаження заявок:', error);
                    });
            }

            function initLikeButtons() {
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
            }

            // Обробка подій
            searchInput.addEventListener('input', fetchApplications);
            sortSelect.addEventListener('change', fetchApplications);
            categorySelect.addEventListener('change', fetchApplications);
            statusSelect.addEventListener('change', fetchApplications);

            filterTermBtn.addEventListener('click', () => {
                urgentFilterActive = !urgentFilterActive;
                if (urgentFilterActive) {
                    filterTermBtn.classList.add('active');
                } else {
                    filterTermBtn.classList.remove('active');
                }
                fetchApplications();
            });

            resetBtn.addEventListener('click', function () {
                searchInput.value = '';
                sortSelect.value = 'urgent_oldest';
                categorySelect.value = '';
                statusSelect.value = '';
                urgentFilterActive = false;
                filterTermBtn.classList.remove('active');
                fetchApplications();
            });

            // Початкове завантаження
            fetchApplications();

            // PDF генерація
            document.querySelectorAll('.generate-all-pdf').forEach(button => {
                button.addEventListener('click', function (e) {
                    e.preventDefault();
                    const url = this.getAttribute('data-url');
                    if (!url) return;

                    showToast('Формується PDF...', 'info');

                    fetch(url, {
                        method: 'GET',
                        headers: {'X-Requested-With': 'XMLHttpRequest'}
                    })
                        .then(response => {
                            if (!response.ok) throw new Error('PDF не вдалося згенерувати.');
                            return response.blob();
                        })
                        .then(blob => {
                            const downloadUrl = window.URL.createObjectURL(blob);
                            const a = document.createElement('a');
                            a.href = downloadUrl;
                            a.download = 'звіт.pdf';
                            document.body.appendChild(a);
                            a.click();
                            a.remove();
                            window.URL.revokeObjectURL(downloadUrl);
                            showToast('Завантаження почалося!', 'success');
                        })
                        .catch(error => {
                            console.error(error);
                            showToast('Сталася помилка при генерації PDF.', 'error');
                        });
                });
            });
        });

        function toggleFilters() {
            const block = document.getElementById('filtersBlock');
            block.classList.toggle('open');
        }
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
        background-color: var(--yellow-my) !important;
        border-radius: 16px;
        border: 1px var(--main-green-dark) solid !important;
        color: var(--main-green-dark) !important;
        gap: 8px;
        font-size: 14px;
        font-weight: 500;
        line-height: 21px;
        padding: 10px 12px !important;
        text-align: center;
        cursor: pointer !important;
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
