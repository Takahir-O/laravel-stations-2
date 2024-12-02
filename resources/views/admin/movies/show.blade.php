<!DOCTYPE html>
<html>

<head>
    <title>Movie Details</title>
</head>

<body>
    <h1>Movie Details</h1>
    <p>ID: {{ $movie->id }}</p>
    <p>映画タイトル: {{ $movie->title }}</p>
    <p>画像URL: {{ $movie->image_url }}</p>
    <p>公開年: {{ $movie->published_year }}</p>
    <p>上映中かどうか: {{ $movie->is_showing ? '上映中' : '上映予定' }}</p>
    <p>概要: {{ $movie->description }}</p>
    <p>登録日時: {{ $movie->created_at }}</p>
    <p>更新日時: {{ $movie->updated_at }}</p>
</body>

</html>