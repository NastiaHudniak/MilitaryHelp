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
    </style>
</head>
<body>
    <h2>Список користувачів</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Логін</th>
                <th>Прізвище</th>
                <th>Імʼя</th>
                <th>Електронна пошта</th>
                <th>Телефон</th>
                <th>Адреса</th>
                <th>Роль</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->login }}</td>
                    <td>{{ $user->surname }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->address }}</td>
                    <td>{{ $user->role->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <p><strong>Загальна кількість користувачів:</strong> {{ $totalUsers }}</p>
</body>
</html>
