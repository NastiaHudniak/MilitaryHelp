@extends('layouts.app')
@include('layouts.header_admin')

@section('content')

    <div class="container" style="max-width: 1300px; padding: 50px 0px;">


        <div class="row mb-4">
            <div class="col-md-4 d-flex align-items-end">
                <a href="{{ route('admin.categories.create') }}" class="btn" style="width: 260px; white-space: nowrap; background-color: var(--green-500);">
                    <i class="fas fa-plus"></i> Додати категорію
                </a>
            </div>

{{--            <div class="col-md-4">--}}
{{--                <label for="category-name-filter" class="form-label" style="margin-left: 200px; width: 250px;">Фільтр за назою категорії</label>--}}
{{--                <div class="input-group" style="width: 250px; margin-left: 200px;">--}}
{{--                    <div class="input-group-prepend">--}}
{{--                        <span class="input-group-text">--}}
{{--                            <i class="fas fa-filter"></i>--}}
{{--                        </span>--}}
{{--                    </div>--}}
{{--                    <select id="name-filter" class="form-control">--}}
{{--                        <option value="">Усі заявки</option>--}}
{{--                        @foreach ($categories as $category)--}}
{{--                            <option value="{{ $category->id }}">{{ $category->name }}</option>--}}
{{--                        @endforeach--}}
{{--                    </select>--}}
{{--                    <div class="input-group-append">--}}
{{--                        <button id="reset-filter" class="btn btn-outline-secondary" type="button">--}}
{{--                            <i class="fas fa-times"></i>--}}
{{--                        </button>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

            <div class="col-md-4 d-flex align-items-end">
                <div class="input-group" style="width: 300px; margin-left: auto;">
                    <input type="text" class="form-control" id="search" placeholder="Пошук за назвою">
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div id="no-results" class="alert alert-info" style="display: none; text-align: center;">
            Заявок не знайдено.
        </div>

        <div class="table-responsive" style="max-height: 560px; overflow-y: auto;">
            <table class="table table-bordered" style="background-color: var(--green-300);">
                <thead class="thead-light" style="background-color: var(--green-500);">
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
        document.getElementById('search').addEventListener('input', function() {
            const query = document.getElementById('search').value;
            const category = document.getElementById('category-filter').value;
            fetchCategories(query, category);
        });

        document.getElementById('category-filter').addEventListener('change', function() {
            const query = document.getElementById('search').value;
            const category = document.getElementById('category-filter').value;
            fetchCategories(query, category);
        });

        document.getElementById('reset-filter').addEventListener('click', function() {
            document.getElementById('search').value = '';
            document.getElementById('category-filter').value = '';

            fetchCategories('', '');
        });

{{--        function fetchCategories(query, category) {--}}
{{--            fetch(`{{ route('admin.applications.filter') }}?query=${encodeURIComponent(query)}&category=${encodeURIComponent(category)}`)--}}
{{--                .then(response => response.json())--}}
{{--                .then(data => {--}}
{{--                    const tableBody = document.getElementById('application-table-body');--}}
{{--                    const noResults = document.getElementById('no-results');--}}
{{--                    tableBody.innerHTML = '';--}}

{{--                    if (data.applications.length === 0) {--}}
{{--                        noResults.style.display = 'block';--}}
{{--                    } else {--}}
{{--                        noResults.style.display = 'none';--}}
{{--                        data.applications.forEach(application => {--}}
{{--                            const row = document.createElement('tr');--}}
{{--                            row.innerHTML = `--}}
{{--                        <td>${application.title}</td>--}}
{{--                        <td>${application.category.name}</td>--}}
{{--                        <td>${application.description}</td>--}}
{{--                        <td>${application.status}</td>--}}
{{--                        <td>${application.comment}</td>--}}
{{--                        <td>${application.volunteer ? application.volunteer.name : ''}</td>--}}
{{--                        <td>${application.millitary ? application.millitary.name : ''}</td>--}}
{{--                        <td>--}}
{{--                            <a href="/admin/applications/${application.id}/edit" class="btn btn-warning btn-sm">--}}
{{--                                <i class="fas fa-edit"></i>--}}
{{--                            </a>--}}
{{--                            <form action="/admin/applications/${application.id}" method="POST" style="display:inline;" onsubmit="return confirmDelete('${application.title}')">--}}
{{--                                <input type="hidden" name="_method" value="DELETE">--}}
{{--                                @csrf--}}
{{--                            <button type="submit" class="btn btn-danger btn-sm" style="margin-left: 10px;">--}}
{{--                                <i class="fas fa-trash"></i>--}}
{{--                            </button>--}}
{{--                        </form>--}}
{{--                    </td>--}}
{{--`;--}}
{{--                            tableBody.appendChild(row);--}}
{{--                        });--}}
{{--                    }--}}
{{--                })--}}
{{--                .catch(error => console.error('Error:', error));--}}
{{--        }--}}

        function confirmDelete(title) {
            return confirm(`Ви впевнені, що хочете видалити заявку "${title}"?`);
        }

        let sortOrder = {};

        function sortTable(columnIndex) {
            const table = document.getElementById("category-table-body");
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
    .btn{
        transition: background-color 0.3s ease, color 0.3s ease; /* Анімація зміни кольору */
    }

    .btn:hover {
        background-color: var(--green-800);
        text-decoration: none;
        transform: scale(1.1);
    }
</style>