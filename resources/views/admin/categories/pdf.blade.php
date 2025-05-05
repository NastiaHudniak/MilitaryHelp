<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        h2 {
            text-align: center;
        }
        th:first-child, td:first-child {
            width: 5%; /* Зменшена ширина першого стовпця */
        }
    </style>
</head>
<body>
    <h2>Список категорій</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Назва категорії</th>
                <th>Кількість заявок</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->applications_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p><strong>Загальна кількість категорій:</strong> {{ $totalCategories }}</p>
</body>
</html>
