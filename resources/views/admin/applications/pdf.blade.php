<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <style>
        @page {
            size: A4 landscape; /* Встановлює альбомну орієнтацію сторінки */
            margin: 20px;
        }
        body {
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed; /* Дозволяє всій таблиці вміщуватися */
            word-wrap: break-word; /* Переносить довгий текст */
            font-size: 14px;
        }
        table, th, td {
            border: 1px solid black;
            padding: 5px;
        }
        th {
            background-color: #f2f2f2;
            text-align: center;
        }
        td {
            text-align: left;
        }
        h2 {
            text-align: center;
        }
        th:first-child, td:first-child {
            width: 5%; /* Зменшена ширина першого стовпця */
        }
        th:nth-child(3), td:nth-child(3) {
            width: 11%; /* Волонтер */
        }
        th:nth-child(4), td:nth-child(4) {
            width: 11%; /* Військовий */
        }
        th:nth-child(7), td:nth-child(7) {
            width: 9%; /* Статус */
        }
    </style>
</head>
<body>
    <h2>Список заявок</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Категорія</th>
                <th>Волонтер</th>
                <th>Військовий</th>
                <th>Назва</th>
                <th>Опис</th>
                <th>Статус</th>
                <th>Коментар</th>
                <th>Дата створення</th>
                <th>Дата оновлення</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($applications as $application)
                <tr>
                    <td>{{ $application->id }}</td>
                    <td>{{ $application->category->name }}</td>
                    <td>{{ $application->volunteer->name ?? 'немає' }}</td>
                    <td>{{ $application->millitary->name }}</td>
                    <td>{{ $application->title }}</td>
                    <td>{{ Str::limit($application->description, 50) }}</td>
                    <td>{{ $application->status }}</td>
                    <td>{{ $application->comment ?? 'немає' }}</td>
                    <td>{{ $application->created_at->format('d.m.Y H:i') }}</td>
                    <td>{{ $application->updated_at->format('d.m.Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <p><strong>Загальна кількість заявок:</strong> {{ $totalApplications }}</p>
</body>
</html>
