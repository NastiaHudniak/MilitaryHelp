    @extends('layouts.app')
    @include('layouts.header_admin')

    @section('content')

        <div class="container mx-auto" style="width: 80%; padding: 50px 0px;">


            <div class="row mb-4 ">
                <div class="col-md-4 d-flex align-items-end">
                    <a href="{{ route('admin.categories.create') }}" class="btn" style="width: 260px; white-space: nowrap; background-color: var(--green-500);">
                        <i class="fas fa-plus"></i> Додати категорію
                    </a>
                </div>
                <div class="col-md-4 d-flex align-items-end">
    
                    <a href="{{ route('admin.categories.export') }}" class="btn" style="width: 260px; white-space: nowrap; background-color: var(--yellow-400);">
                    <i class="fas fa-file-pdf"></i> Експортувати в PDF
                </a>
                </div>

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

            <div class="table-responsive mx-auto" style="max-height: 560px; overflow-y: auto; width: 100%;">
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
        .btn{
            transition: background-color 0.3s ease, color 0.3s ease; /* Анімація зміни кольору */
        }

        .btn:hover {
            background-color: var(--green-800);
            text-decoration: none;
            transform: scale(1.1);
        }
    </style>
