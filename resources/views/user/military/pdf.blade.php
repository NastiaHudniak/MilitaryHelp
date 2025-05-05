<!DOCTYPE html>
<html>
<head>
    <style>
        .header { text-align: center; font-size: 20px; font-weight: bold; margin-bottom: 20px; }
        .content { font-size: 16px; margin-bottom: 10px; }
        .label { font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">Інформація про заявку #{{ $application->id }}</div>
    
    <div class="content">
        <span class="label">Назва:</span> {{ $application->title }}
    </div>
    <div class="content">
        <span class="label">Категорія:</span> {{ $application->category->name }}
    </div>
    <div class="content">
        <span class="label">Опис:</span> {{ $application->description }}
    </div>
    <div class="content">
        <span class="label">Статус:</span> {{ $application->status }}
    </div>
    <div class="content">
        <span class="label">Коментар:</span> {{ $application->comment ?? 'Немає' }}
    </div>
</body>
</html>
