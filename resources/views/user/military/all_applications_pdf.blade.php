<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 5px;
            text-align: left;
        }

        .section {
            margin-bottom: 40px;
        }

        .application-block {
            margin-bottom: 30px;
        }

        .status-created {
            color: #0BBF0B;
        }

        .status-accepted {
            color: #0B65BF;
        }

        .status-rejected {
            color: #FF1D4E;
        }

        .image-wrapper {
            display: inline-block;
            width: 100px;
            height: 100px;
            margin: 6px 6px 0 0;
            overflow: hidden;
            border: 1px solid #ccc;
        }

        .image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .title {
            font-weight: bold;
            margin-bottom: 4px;
        }

        .label {
            font-weight: bold;
        }

        .small-gap {
            margin-top: 6px;
            margin-bottom: 6px;
        }
    </style>
</head>
<body>

<h2>Заявки військового: {{ $fullName }}</h2>
<p>Дата: {{ $date }}</p>
<p>Кількість заявок: {{ $applicationCount }}</p>

{{-- Таблиця --}}
<table class="application-table">
    <thead>
    <tr>
        <th>#</th>
        <th>Назва</th>
        <th>Категорія</th>
        <th>Опис</th>
        <th>Статус</th>
        <th>Волонтер</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($applications as $index => $application)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $application->title }}</td>
            <td>{{ $application->category->name }}</td>
            <td>{{ $application->description }}</td>
            <td>{{ $application->status }}</td>
            <td>{{ $application->volunteer?->name ?? '—' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>


{{-- Деталі по кожній --}}
{{-- Деталі по кожній --}}
@foreach($applications as $index => $application)
    <div class="application-block">

        <div class="small-gap">
            <span class="label">Заявка {{ $index + 1 }}:</span>
            <span class="title">Назва "{{ $application->title }}"</span>
        </div>

        <div class="small-gap"><span class="label">Категорія:</span> {{ $application->category->name }}</div>
        <div class="small-gap"><span class="label">Опис:</span> {{ $application->description }}</div>
        <div class="small-gap"><span class="label">Статус:</span>
            <span class="status-{{ $application->status }}">{{ $application->status }}</span>
        </div>

        @if ($application->volunteer)
            <div class="small-gap"><span class="label">Волонтер:</span> {{ $application->volunteer->name }}</div>
            <div class="small-gap"><span class="label">Коментар:</span> {{ $application->comment ?? 'Немає' }}</div>
        @endif

        @if ($application->images->count())
            <div class="small-gap"><span class="label">Зображення:</span></div>
            @foreach ($application->images as $image)
                @php
                    $imagePath = public_path('storage/' . $image->image_url);
                @endphp

                @if (file_exists($imagePath) && is_file($imagePath))
                    <div class="image-wrapper">
                        <img src="{{ $imagePath }}" alt="Зображення">
                    </div>
                @endif
            @endforeach
        @endif

    </div>
@endforeach

</body>
</html>
