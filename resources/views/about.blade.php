<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>About Us</title>
</head>
<body>
<h1>Мене звати {{ $name }}</h1>
<p>Я {{ $role }}</p>
<p>{{ $description }}</p>

<li><a href="{{ url('/') }}" class="btn btn-info" role="button">Головна</a></li>
</body>
</html>
