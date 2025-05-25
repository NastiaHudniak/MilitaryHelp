@extends('layouts.app')
@include('layouts.header_military')

@section('content')
    <div class="main-content" style="font-family: 'Open Sans', sans-serif;">
        <div class="filters-blocks">
            <div class="navigation-bar">
                <nav class="navbar-search">
                    <div class="search-title">
                        <img src="{{ asset('images/icon/search.svg') }}" >
                        <input type="text" class="search" id="search" placeholder="Пошук за назвою">
                    </div>
                </nav>
                <div class="buttons">
                    <a type="submit" class="button-add-application" href="{{ route('user.military.create') }}">
                        <img src="{{ asset('images/icon/znak-white.svg') }}" >
                        Додати заявку
                    </a>
                    <a type="submit" class="button-report">
                        <img src="{{ asset('images/icon/pdf.svg') }}" >
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
                            <option value="latest">Останнi</option>
                            <option value="oldest">Старіші</option>
                            <option value="status">Статус</option>
                        </select>
                    </div>
                </div>

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

        <div id="no-results" class="alert alert-info" style="display: none; text-align: center;">
            Заявок не знайдено.
        </div>

        <div class="application-block" id="application-card-container">
            @foreach($applications as $application)
                @include('components.application-card-mil', ['application' => $application])
            @endforeach
        </div>


    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('search');
            const sortSelect = document.getElementById('sort-filter');
            const categoryFilter = document.getElementById('category-filter');
            const statusFilter = document.getElementById('status-filter');
            const resetButton = document.getElementById('reset-filter');
            const cards = document.querySelectorAll('#application-card-container .col-md-3');
            const noResults = document.getElementById('no-results');

            function filterCards() {
                const search = searchInput.value.toLowerCase();
                const category = categoryFilter.value;
                const status = statusFilter.value;

                let visibleCount = 0;

                cards.forEach(card => {
                    const title = card.querySelector('.card-title').textContent.toLowerCase();
                    const categoryText = card.querySelector('.card-subtitle') ? card.querySelector('.card-subtitle').textContent : '';
                    const statusText = card.querySelector('.card-text span') ? card.querySelector('.card-text span').textContent : '';

                    const matchSearch = !search || title.includes(search);
                    const matchCategory = !category || categoryText.trim() === category;
                    const matchStatus = !status || statusText.trim() === status;

                    if (matchSearch && matchCategory && matchStatus) {
                        card.style.display = '';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                noResults.style.display = visibleCount === 0 ? 'block' : 'none';
            }

            function resetFilters() {
                searchInput.value = '';
                categoryFilter.value = '';
                statusFilter.value = '';
                sortSelect.value = 'latest';
                filterCards();
            }

            searchInput.addEventListener('input', filterCards);
            categoryFilter.addEventListener('change', filterCards);
            statusFilter.addEventListener('change', filterCards);
            resetButton.addEventListener('click', resetFilters);
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
