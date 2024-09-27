<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Welcome</title>
</head>
<body>
<h1>Головна сторінка</h1>


<nav>
    <ul>
        <li><a href="{{ url('/about') }}" class="btn btn-info" role="button">Про нас</a></li>
        <li><a href="{{ url('/contact') }}" class="btn btn-info" role="button">Контакти</a></li>
        <li><a href="{{ url('/hobbies') }}" class="btn btn-info" role="button">Хобі</a></li>
    </ul>
</nav>
<style>
    nav ul {
        list-style-type: none;
        padding: 0;
    }

    nav ul li {
        display: inline-block;
        margin-right: 15px;
    }

    nav ul li:last-child {
        margin-right: 0;
    }
</style>
</body>
</html>
