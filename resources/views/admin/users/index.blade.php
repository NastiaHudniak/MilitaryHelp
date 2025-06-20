@extends('layouts.app')
@include('layouts.header_admin')
@section('content')

    <div class="main-content" style="font-family: 'Open Sans', sans-serif;">


        <div class="filters-blocks" id="filtersBlock">

            <div class="navigation-bar">
                <div class="buttons">
                    <a type="submit" class="button-add-application" href="{{ route('admin.users.create') }}">
                        <img src="{{ asset('images/icon/znak-white.svg') }}" >
                        Додати заявку
                    </a>
                    <a href="{{ route('admin.users.export') }}" class="button-report generate-all-pdf">
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
            <div class="filter-bar">
                <div class="sort-filter-block">
                    <label for="application-sort-filter" class="label-sort-filter">
                        <img src="{{ asset('images/icon/filter.svg') }}">
                        Фільтр за:
                    </label>
                    <div class="sort-select" style="border-right: 1px solid var(--orange-my);">
                        <select id="role-filter" class="sort-input">
                            <option value="">Усі користувачі</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
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
            Користувачів не знайдено.
        </div>

        <div class="table-responsive" style="max-height: 440px; overflow-y: auto;">
            <table class="table table-bordered" style="background-color: var(--yellow-my);">
                <thead class="thead-light" style="background-color: var(--green-light);">
                <tr>
                    <th style="min-width: 120px; position: sticky; top: 0; z-index: 1; cursor: pointer;" onclick="sortTable(0)">
                        Логін <i id="sortIcon0" class="fas fa-sort"></i>
                    </th>
                    <th style="min-width: 150px; position: sticky; top: 0; z-index: 1; cursor: pointer;" onclick="sortTable(1)">
                        Прізвище <i id="sortIcon1" class="fas fa-sort"></i>
                    </th>
                    <th style="min-width: 150px; position: sticky; top: 0; z-index: 1; cursor: pointer;" onclick="sortTable(2)">
                        Імʼя <i id="sortIcon2" class="fas fa-sort"></i>
                    </th>
                    <th style="min-width: 200px; position: sticky; top: 0; z-index: 1; cursor: pointer;" onclick="sortTable(3)">
                        Електронна пошта <i id="sortIcon3" class="fas fa-sort"></i>
                    </th>
                    <th style="min-width: 100px; position: sticky; top: 0; z-index: 1; cursor: pointer;" onclick="sortTable(4)">
                        Телефон <i id="sortIcon4" class="fas fa-sort"></i>
                    </th>
                    <th style="min-width: 150px; position: sticky; top: 0; z-index: 1; cursor: pointer;" onclick="sortTable(5)">
                        Адреса <i id="sortIcon5" class="fas fa-sort"></i>
                    </th>
                    <th style="min-width: 100px; position: sticky; top: 0; z-index: 1; cursor: pointer;" onclick="sortTable(6)">
                        Роль <i id="sortIcon6" class="fas fa-sort"></i>
                    </th>
                    <th style="min-width: 105px; position: sticky; top: 0; z-index: 1;">
                        Дії
                    </th>
                </tr>
                </thead>
                <tbody id="user-table-body">
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->login }}</td>
                        <td>{{ $user->surname }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->address }}</td>
                        <td>{{ $user->role->name }}</td>
                        <td>
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete('{{ $user->login }}')">
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
            btn.style.pointerEvents = 'none';  // заборона повторних кліків
            btn.innerHTML = '<img src="{{ asset("images/icon/pdf.svg") }}" style="opacity: 0.5;"> Завантаження...';
            showToast('Формується PDF...', 'info');
            fetch(btn.href)
                .then(response => {
                    if (!response.ok) throw new Error('Помилка при формуванні PDF');
                    return response.blob();  // отримуємо PDF як Blob
                })
                .then(blob => {
                    // створюємо тимчасовий URL для завантаження
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = 'users_report.pdf';  // ім'я файлу для завантаження
                    document.body.appendChild(a);
                    a.click();
                    a.remove();
                    window.URL.revokeObjectURL(url);

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


        document.getElementById('search').addEventListener('input', function() {
            const query = document.getElementById('search').value;
            const role = document.getElementById('role-filter').value;
            fetchUsers(query, role);
        });

        document.getElementById('role-filter').addEventListener('change', function() {
            const query = document.getElementById('search').value;
            const role = document.getElementById('role-filter').value;
            fetchUsers(query, role);
        });

        document.getElementById('reset-filter').addEventListener('click', function() {
            document.getElementById('search').value = '';
            document.getElementById('role-filter').value = '';

            fetchUsers('', '');
        });

        function fetchUsers(query, role) {
            fetch(`{{ route('admin.users.filter') }}?query=${encodeURIComponent(query)}&role=${encodeURIComponent(role)}`)
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.getElementById('user-table-body');
                    const noResults = document.getElementById('no-results');
                    tableBody.innerHTML = '';

                    if (data.users.length === 0) {
                        noResults.style.display = 'block';
                    } else {
                        noResults.style.display = 'none';
                        data.users.forEach(user => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                        <td>${user.login}</td>
                        <td>${user.surname}</td>
                        <td>${user.name}</td>
                        <td>${user.email}</td>
                        <td>${user.phone}</td>
                        <td>${user.address}</td>
                        <td>${user.role.name}</td>
                        <td>
                            <a href="/admin/users/${user.id}/edit" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="/admin/users/${user.id}" method="POST" style="display:inline;" onsubmit="return confirmDelete('${user.login}')">
                                <input type="hidden" name="_method" value="DELETE">
                                @csrf
                            <button type="submit" class="btn btn-danger btn-sm" style="margin-left: 10px">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>`;
                            tableBody.appendChild(row);
                        });
                    }
                });
        }

        function confirmDelete(login) {
            return confirm(`Ви точно бажаєте видалити користувача з логіном "${login}"?`);
        }

        let sortOrder = {};

        function sortTable(columnIndex) {
            const table = document.getElementById("user-table-body");
            const rows = Array.from(table.getElementsByTagName("tr"));

            let ascending = sortOrder[columnIndex] === "asc" ? false : true;
            sortOrder[columnIndex] = ascending ? "asc" : "desc";

            rows.sort((a, b) => {
                const cellA = a.getElementsByTagName("td")[columnIndex].innerText.toLowerCase();
                const cellB = b.getElementsByTagName("td")[columnIndex].innerText.toLowerCase();

                if (cellA < cellB) return ascending ? -1 : 1;
                if (cellA > cellB) return ascending ? 1 : -1;
                return 0;
            });

            while (table.firstChild) {
                table.removeChild(table.firstChild);
            }

            rows.forEach(row => table.appendChild(row));

            updateSortIcons(columnIndex, ascending);
        }

        function updateSortIcons(columnIndex, ascending) {
            for (let i = 0; i < 7; i++) {
                const icon = document.getElementById(`sortIcon${i}`);
                if (i === columnIndex) {
                    icon.className = ascending ? "fas fa-sort-up" : "fas fa-sort-down";
                } else {
                    icon.className = "fas fa-sort";
                }
            }
        }

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
