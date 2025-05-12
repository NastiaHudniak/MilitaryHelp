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
            @foreach ($applications as $application)
                <div class="card-application">
                    <div class="card-foto" >
                        <div class="image-scroll-container" style="overflow-x: auto; white-space: nowrap; margin: 0">
                            @foreach ($application->images as $image)
                                <img src="{{ asset('storage/' . $image->image_url) }}" alt="Зображення заявки" class="img-fluid" style="max-height: 130px; object-fit: cover; display: inline-block">
                            @endforeach
                        </div>
{{--                        <div class="imnav">--}}
{{--                            <a href="{{ route('user.military.images.create', $application) }}" class="btn btn-warning" style="background-color: var(--yellow-500);">--}}
{{--                                <i class="fas fa-add"></i>--}}
{{--                            </a>--}}
{{--                            <a href="{{ route('user.military.images.edit', $application) }}" class="btn btn-warning" style="background-color: var(--yellow-500);">--}}
{{--                                <i class="fas fa-edit"></i>--}}
{{--                            </a>--}}
{{--                        </div>--}}

{{--                        <p class="card-text flex-grow-1">{{ $application->description }}</p>--}}
{{--                        <p class="card-text">--}}
{{--                            <strong style="color: #000000;">Статус:</strong>--}}
{{--                            <span class="--}}
{{--        @if ($application->status === 'створено') text-primary--}}
{{--        @elseif ($application->status === 'прийнято') text-success--}}
{{--        @elseif ($application->status === 'відхилено') text-danger--}}
{{--        @endif--}}
{{--    ">--}}
{{--        {{ $application->status }}--}}
{{--    </span>--}}
{{--                        </p>--}}
                    </div>
                    <div class="card-header-app" >
                        <h5 class="card-title-app" >{{ $application->title }}</h5>
                        <h6 class="card-subtitle-app" >{{ $application->category->name }}</h6>
                    </div>
                    <div class="buttons-blocks">
                        <a href="javascript:void(0);" class="button-view-info"  data-toggle="modal" data-target="#applicationModal{{ $application->id }}">
                            Детальніше
                            <img src="{{ asset('images/icon/info.svg') }}">
                        </a>
                        <div class="card-buttons" >
{{--                            <a href="{{ route('user.military.pdf', $application->id) }}" class="btn btn-sm" style="background-color: var(--yellow-500);">PDF</a>--}}

                            <a href="{{ route('user.military.edit', $application) }}" class="button-actions">
                                <img src="{{ asset('images/icon/edit.svg') }}">
                            </a>
                            <form action="{{ route('user.military.destroy', $application) }}"
                                  method="POST"
                                  style="display:inline;"
                                  onsubmit="return confirmDelete('{{ $application->title }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="button-actions">
                                    <img src="{{ asset('images/icon/delete.svg') }}" style="width: 32px; height: 32px">
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
                @foreach ($applications as $application)
                    <div style=" top: 10%; !important;left: 30%; !important;" class="modal"
                         id="applicationModal{{ $application->id }}"
                         tabindex="-1"
                         aria-labelledby="applicationModalLabel{{ $application->id }}"
                         aria-hidden="true"
                         data-bs-backdrop="static"
                         data-bs-keyboard="false">
                        <div class="modal-info-block" >
                            <div class="modal-status-close">
                                <p class="info-status
                        @if ($application->status === 'створено') status-created
                        @elseif ($application->status === 'прийнято') status-accepted
                        @elseif ($application->status === 'відхилено') status-rejected
                        @endif">
                                    {{ $application->status }}
                                </p>
                                <button type="button" class="close-button" data-bs-dismiss="modal" aria-label="Close">
                                    <img src="{{ asset('images/icon/cancell.svg') }}">
                                </button>
                            </div>

                            <div class="modal-text">
                                <div class="modal-title">
                                    <p class="info-title">{{ $application->title }}</p>
                                    <p class="info-category">{{ $application->category->name }}</p>
                                </div>
                                <div class="modal-description">
                                    <p class="info-description">{{ $application->description }}</p>
                                </div>
                            </div>

                            <div class="modal-foto">
                                <div class="image-scroll-container" style="overflow-x: auto; white-space: nowrap; margin: 0">
                                    @foreach ($application->images as $image)
                                        <img src="{{ asset('storage/' . $image->image_url) }}"
                                             alt="Зображення заявки"
                                             class="img-fluid"
                                             style="max-height: 130px; object-fit: cover; display: inline-block">
                                    @endforeach
                                </div>
                                <div class="navigation-modal-photo">
                                    <a href="{{ route('user.military.images.create', $application) }}" class="button-images" type="button">
                                        <img src="{{ asset('images/icon/znak.svg') }}">
                                    </a>
                                    <a href="{{ route('user.military.images.edit', $application) }}" class="button-images" type="button">
                                        <img src="{{ asset('images/icon/edit.svg') }}" style="width: 28px">
                                    </a>
                                </div>
                            </div>

                            @if ($application->volunteer)
                                <div class="modal-text-volunteers">
                                    <p class="info-vol">
                                        <strong class="info-vol">Заявку прийняв волонтер:</strong>
                                        {{ $application->volunteer->name }}
                                    </p>
                                    <p class="info-vol">
                                        <strong class="info-vol">Коментар:</strong>
                                        {{ $application->comment }}
                                    </p>
                                </div>
                            @endif

                            <div class="modal-footer">
                                <a href="{{ route('user.military.pdf', $application->id) }}" class="button-report" type="button">
                                    <img src="{{ asset('images/icon/pdf.svg') }}">
                                    Сформувати звіт в .pdf
                                </a>
                                <div class="card-buttons">
                                    <a href="{{ route('user.military.edit', $application) }}" class="button-actions" type="button">
                                        <img src="{{ asset('images/icon/edit.svg') }}" style="width: 32px; height: 32px">
                                    </a>
                                    <form action="{{ route('user.military.destroy', $application) }}"
                                          method="POST"
                                          style="display:inline;"
                                          onsubmit="return confirmDelete('{{ $application->title }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="button-actions">
                                            <img src="{{ asset('images/icon/delete.svg') }}" style="width: 32px; height: 32px">
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        </div>
                    </div>
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


    @include('layouts.footer_landing')
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
        width: auto;
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

    .application-block{
        width: 100%;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 36px;
        padding: 64px 80px;
    }

    .card-application{
        width: calc(25% - 27px);
        display: flex;
        justify-content: flex-end;
        align-items: flex-start;
        flex-direction: column;
        padding: 16px;
        gap: 24px;
        background-color: var(--yellow-my);
        border-radius: 16px;
    }

    .card-foto{
        padding: 0;
    }

    .card-header-app{
        display: flex;
        justify-content: flex-start;
        align-items: flex-start;
        flex-direction: column;
        gap: 0;
        background-color: transparent; !important;
        border: none; !important;

    }

    .card-title-app {
        color: var(--black-my);
        font-size: 20px;
        font-weight: 600;
        line-height: 30px;
        word-wrap: break-word;
        margin: 0;
    }

    .card-subtitle-app{
        color: var(--main-green-dark);
        font-size: 16px;
        font-weight: 400;
        line-height: 24px;
        word-wrap: break-word;
        margin: 0;
    }

    .image-scroll-container::-webkit-scrollbar {
        height: 8px;
    }

    .image-scroll-container::-webkit-scrollbar-track {
        background: var(--green-light);
    }

    .image-scroll-container::-webkit-scrollbar-thumb {
        background: var(--orange-my);
        border-radius: 10px;
    }

    .image-scroll-container::-webkit-scrollbar-thumb:hover {
        background: var(--orange-my);
    }
    .image-scroll-container img {
        height: 130px;
        width: auto;
        object-fit: cover;
        display: inline-block;
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
        line-height: 21px;
        padding: 6px 16px;
        text-align: center;
        cursor: pointer;
        text-decoration: none;
        transition: background-color 0.5s ease, color 0.5s ease;
    }

    .card-buttons{
        display: flex;
        align-items: center;
        flex-direction: row;
        padding: 0;
        gap: 16px;
    }

    .button-actions{
        text-decoration: none;
        border: none;
        background-color: transparent;
        padding: 0;
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

    .modal-status-close{
        display: flex;
        justify-content: space-between;
        flex-direction: row;
        padding: 0;
        margin: 0;

    }

    .info-status {
        display: flex;
        padding: 4px 16px;
        margin: 0 !important;
        border-radius: 16px;
        font-size: 14px;
        font-weight: 400;
        line-height: 21px;
        border: 1px solid;
    }

    .status-created {
        border-color: var(--green-100);
        background-color: var(--green-15);
        color: var(--green-100);
    }

    .status-accepted {
        border-color: var(--blue-100);
        background-color: var(--blue-15);
        color: var(--blue-100);
    }

    .status-rejected {
        border-color: var(--red-100);
        background-color: var(--red-15);
        color: var(--red-100);
    }


    .close-button{
        padding: 0;
        margin: 0;
        background-color: transparent;
        border: none;
    }

    .modal-text{
        display: flex;
        justify-content: start;
        flex-direction: column;
        gap: 12px;
    }

    .modal-title, .modal-description{
        display: flex;
        justify-content: start;
        flex-direction: column;
        gap: 0;

    }

    .info-title{
        color: var(--black-my);
        font-size: 20px;
        font-weight: 600;
        line-height: 30px;
        word-wrap: break-word;
        margin: 0;
    }

    .info-category{
        color: var(--greey-my);
        font-size: 16px;
        font-weight: 400;
        line-height: 24px;
        word-wrap: break-word;
        margin: 0;
    }

    .info-description{
        color: var(--green-dark);
        font-size: 16px;
        font-weight: 400;
        line-height: 24px;
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

    .navigation-modal-photo{
        height: fit-content;
        display: flex;
        justify-content: center;
        padding: 8px 4px;
        flex-direction: column;
        gap: 16px;
        border-radius: 16px;
        background-color: var(--yellow-my);
    }

    .modal-footer{
        width: 100%;
        display: flex;
        align-items: start;
        justify-content: start;
        flex-direction: row;
        gap: 16px;
    }

    .modal-text-volunteers{
        display: flex;
        justify-content: start;
        flex-direction: column;
        gap: 0;
    }

    .info-vol{
        color: var(--orange-my);
        font-size: 16px;
        font-weight: 400;
        line-height: 24px;
        word-wrap: break-word;
        margin: 0;
    }






</style>
