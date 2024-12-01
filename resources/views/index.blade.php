<!DOCTYPE html>
<html>

<head>
    <title>Movies</title>
</head>

<body>
    <h1>Movies List</h1>
    <ul>
        @foreach ($movies as $movie)
        <li>
            <h2>{{ $movie->title }}</h2>
            <img src="{{ $movie->image_url }}" alt="{{ $movie->title }}">
        </li>
        @endforeach
    </ul>
</body>

</html>