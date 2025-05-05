@extends('layouts.app')
@include('layouts.header_admin')

@section('content')

<div class="container" style="max-width: 1300px; padding: 50px 0px;">
    <div class="row mb-4">
        <div class="d-flex align-items-end">
            <a href="{{ route('admin.applications.create') }}" class="btn" style="width: 260px; white-space: nowrap; background-color: var(--green-500);">
                <i class="fas fa-plus"></i> Додати заявку
            </a>
        </div>
        <div class="d-flex align-items-end">
    
                    <a href="{{ route('admin.applications.export') }}" class="btn" style=" margin-left:10px; width: 260px; white-space: nowrap; background-color: var(--yellow-400);">
                    <i class="fas fa-file-pdf"></i> Експортувати в PDF
                </a>
                </div>

        <div class="col-md-4">
            <label for="application-category-filter" class="form-label" style=" width: 250px;">Фільтр за категорією заявки</label>
            <div class="input-group" style="width: 250px;">
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

        <div class="d-flex align-items-end">
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

    <div class="table-responsive" style="max-height: 440px; overflow-y: auto;">
        <table class="table table-bordered table-sm" style="background-color: var(--green-300); table-layout: fixed;">
            <thead class="thead-light" style="background-color: var(--green-500);">
                <tr>
                    <th style="width: 100px; position: sticky; top: 0; z-index: 1; cursor: pointer;" onclick="sortTable(0)">
                        Назва <i id="sortIcon0" class="fas fa-sort"></i>
                    </th>
                    <th style="width: 100px; position: sticky; top: 0; z-index: 1; cursor: pointer;" onclick="sortTable(1)">
                        Категорія <i id="sortIcon1" class="fas fa-sort"></i>
                    </th>
                    <th style="width: 150px; position: sticky; top: 0; z-index: 1; cursor: pointer;" onclick="sortTable(2)">
                        Опис <i id="sortIcon2" class="fas fa-sort"></i>
                    </th>
                    <th style="width: 70px; position: sticky; top: 0; z-index: 1; cursor: pointer;" onclick="sortTable(3)">
                        Статус <i id="sortIcon3" class="fas fa-sort"></i>
                    </th>
                    <th style="width: 120px; position: sticky; top: 0; z-index: 1; cursor: pointer;" onclick="sortTable(4)">
                        Коментар <i id="sortIcon4" class="fas fa-sort"></i>
                    </th>
                    <th style="width: 80px; position: sticky; top: 0; z-index: 1; cursor: pointer;" onclick="sortTable(5)">
                        Волонтер <i id="sortIcon5" class="fas fa-sort"></i>
                    </th>
                    <th style="width: 80px; position: sticky; top: 0; z-index: 1; cursor: pointer;" onclick="sortTable(6)">
                        Військовий <i id="sortIcon6" class="fas fa-sort"></i>
                    </th>
                    <th style="width: 80px; position: sticky; top: 0; z-index: 1;">
                        Фото
                    </th>
                    <th style="width: 80px; position: sticky; top: 0; z-index: 1;">
                        Дії
                    </th>
                </tr>
            </thead>
            <tbody id="application-table-body">
                @foreach ($applications as $application)
                    <tr>
                        <td>{{ $application->title }}</td>
                        <td>{{ $application->category->name }}</td>
                        <td>{{ $application->description }}</td>
                        <td>{{ $application->status }}</td>
                        <td>{{ $application->comment }}</td>
                        <td>{{ $application->volunteer ? $application->volunteer->name : '' }}</td>
                        <td>{{ $application->millitary ? $application->millitary->name : '' }}</td>
                        <td>
                            <a href="{{ route('admin.applications.images.create', $application) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-add"></i>
                            </a>
                            <a href="{{ route('admin.applications.images.edit', $application) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('admin.applications.edit', $application) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.applications.destroy', $application) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete('{{ $application->title }}')">
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
        fetchApplications(query, category);
    });

    document.getElementById('category-filter').addEventListener('change', function() {
        const query = document.getElementById('search').value;
        const category = document.getElementById('category-filter').value;
        fetchApplications(query, category);
    });

    document.getElementById('reset-filter').addEventListener('click', function() {
        document.getElementById('search').value = '';
        document.getElementById('category-filter').value = '';

        fetchApplications('', '');
    });

    function fetchApplications(query, category) {
        fetch(`{{ route('admin.applications.filter') }}?query=${encodeURIComponent(query)}&category=${encodeURIComponent(category)}`)
            .then(response => response.json())
            .then(data => {
                const tableBody = document.getElementById('application-table-body');
                const noResults = document.getElementById('no-results');
                tableBody.innerHTML = '';

                if (data.applications.length === 0) {
                    noResults.style.display = 'block';
                } else {
                    noResults.style.display = 'none';
                    data.applications.forEach(application => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${application.title}</td>
                            <td>${application.category.name}</td>
                            <td>${application.description}</td>
                            <td>${application.status}</td>
                            <td>${application.comment}</td>
                            <td>${application.volunteer ? application.volunteer.name : ''}</td>
                            <td>${application.millitary ? application.millitary.name : ''}</td>
                            <td>
                                <a href="/admin/applications/${application.id}/edit" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="/admin/applications/${application.id}" method="POST" style="display:inline;" onsubmit="return confirmDelete('${application.title}')">
                                    <input type="hidden" name="_method" value="DELETE">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm" style="margin-left: 10px;">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        `;
                        tableBody.appendChild(row);
                    });
                }
            })
            .catch(error => console.error('Error:', error));
    }

    function confirmDelete(title) {
        return confirm(`Ви впевнені, що хочете видалити заявку "${title}"?`);
    }

    let sortOrder = {};

    function sortTable(columnIndex) {
        const table = document.getElementById("application-table-body");
        const rows = Array.from(table.getElementsByTagName("tr"));

        let ascending = sortOrder[columnIndex] === "asc" ? false : true;
        sortOrder[columnIndex] = ascending ? "asc" : "desc";

        rows.sort((a, b) => {
            const cellA = a.getElementsByTagName("td")[columnIndex].innerText.toLowerCase();
            const cellB = b.getElementsByTagName("td")[columnIndex].innerText.toLowerCase();
            
            return ascending ? (cellA.localeCompare(cellB)) : (cellB.localeCompare(cellA));
        });

        table.innerHTML = "";
        rows.forEach(row => table.appendChild(row));

        for (let i = 0; i <= 6; i++) {
            document.getElementById(`sortIcon${i}`).className = "fas fa-sort";
        }
        document.getElementById(`sortIcon${columnIndex}`).className = ascending ? "fas fa-sort-up" : "fas fa-sort-down";
    }
</script>

@endsection
