    @extends('layouts.app')
    @include('layouts.header_admin')

    @section('content')

        <div class="main-content" style="font-family: 'Open Sans', sans-serif;">


            <div class="filters-blocks" id="filtersBlock">

                <div class="navigation-bar">
                    <div class="buttons">
                        <a type="submit" class="button-add-application" href="{{ route('admin.categories.create') }}">
                            <img src="{{ asset('images/icon/znak-white.svg') }}" >
                            Додати категорію
                        </a>
                        <a href="#"
                           class="button-report generate-all-pdf"
                           data-url="{{ route('admin.categories.export') }}">
                            <img src="{{ asset('images/icon/pdf.svg') }}">
                            Сформувати звіт в .pdf
                        </a>

                    </div>

                    <nav class="navbar-search">
                        <div class="search-title">
                            <img src="{{ asset('images/icon/search.svg') }}" >
                            <input type="text" class="search" id="search" placeholder="Пошук за назвою">
                        </div>
                    </nav>
                </div>

            </div>


            <div id="no-results" class="alert alert-info" style="display: none; text-align: center;">
                Заявок не знайдено.
            </div>

            <div class="table-responsive" style="max-height: 440px; overflow-y: auto;">
                <table class="table table-bordered table-sm" style="background-color: var(--yellow-my); table-layout: fixed;">
                    <thead class="thead-light" style="background-color: var(--green-light);">
                    <tr>
                        <th style="min-width: 120px; position: sticky; top: 0; z-index: 1; cursor: pointer;" onclick="sortTable(0)">
                            Назва <i id="sortIcon0" class="fas fa-sort"></i>
                        </th>
                        <th style="min-width: 105px; position: sticky; top: 0; z-index: 1;">
                            Дії
                        </th>
                    </tr>
                    </thead>
                    <tbody id="category-table-body">
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            <td>
                                <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete('{{ $category->name }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" style="margin-left: 10px;">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <script>
            document.querySelector('.generate-all-pdf').addEventListener('click', function(e) {
                e.preventDefault();

                const btn = this;
                const url = btn.getAttribute('data-url');
                btn.style.pointerEvents = 'none';  // заборона повторних кліків
                btn.innerHTML = '<img src="{{ asset("images/icon/pdf.svg") }}" style="opacity: 0.5;"> Завантаження...';
                showToast('Формується PDF...', 'info');

                fetch(url)
                    .then(response => {
                        if (!response.ok) throw new Error('Помилка при формуванні PDF');
                        return response.blob();
                    })
                    .then(blob => {
                        const downloadUrl = window.URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = downloadUrl;
                        a.download = 'categories_report.pdf';
                        document.body.appendChild(a);
                        a.click();
                        a.remove();
                        window.URL.revokeObjectURL(downloadUrl);

                        btn.innerHTML = '<img src="{{ asset("images/icon/pdf.svg") }}"> Сформувати звіт в .pdf';
                        btn.style.pointerEvents = 'auto';
                        showToast('Файл успішно завантажено', 'success');
                    })
                    .catch(err => {
                        console.error(err);
                        showToast('Сталася помилка при генерації PDF.', 'error');
                        btn.innerHTML = '<img src="{{ asset("images/icon/pdf.svg") }}"> Сформувати звіт в .pdf';
                        btn.style.pointerEvents = 'auto';
                    });
            });


        document.getElementById('search').addEventListener('input', function () {
            let query = this.value;

            fetch(`/admin/categories/search?query=${query}`)
                .then(response => response.json())
                .then(data => {
                    let tbody = document.getElementById('category-table-body');
                    tbody.innerHTML = '';

                    if (data.categories.length === 0) {
                        document.getElementById('no-results').style.display = 'block';
                    } else {
                        document.getElementById('no-results').style.display = 'none';
                    }

                    data.categories.forEach(category => {
                        let row = document.createElement('tr');

                        let nameCell = document.createElement('td');
                        nameCell.textContent = category.name;
                        row.appendChild(nameCell);

                        let actionsCell = document.createElement('td');
                        actionsCell.innerHTML = `
                            <a href="/admin/categories/${category.id}/edit" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="/admin/categories/${category.id}" method="POST" style="display:inline;" onsubmit="return confirmDelete('${category.name}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" style="margin-left: 10px;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        `;
                        row.appendChild(actionsCell);

                        tbody.appendChild(row);
                    });
                });
        });
    </script>

    @endsection
    <style>
        .main-content {
            background-color: var(--main-white);
            max-width: 100%;
            margin: 0 auto;
        }

        .table-responsive{
            padding: 0 80px;
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
