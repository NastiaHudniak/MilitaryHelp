<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>My Hobbies</title>
</head>
<body>
<h1>Мої хобі:</h1>
<ul>
    @foreach ($hobbies as $hobby)
        <li>{{ $hobby }}</li>
    @endforeach
</ul>
<li><a href="{{ url('/') }}" class="btn btn-info" role="button">Головна</a></li>
</body>
</html>
