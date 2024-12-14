<!DOCTYPE html>
<html>

<head>
    <title>{{ $movie->title }}</title>
</head>

<body>
    <h1>{{ $movie->title }}</h1>
    <img src="{{$movie->image_url}}" alt="{{$movie->title}}" width="200">
    <p>公開年: {{$movie->published_year}}</p>
    <p>ジャンル:{{$movie->genre->name}}</p>
    <p>概要: {{$movie->description}}</p>
    <p>上映中:{{$movie->is_showing ? 'はい':'いいえ'}}</p>
    <p>作成日時:{{$movie->created_at}}</p>
    <p>更新日時:{{$movie->updated_at}}</p>

    <h2>上映スケジュール</h2>
    @if ($schedules->isEmpty())
    <p>上映スケジュールはありません</p>
    @else
    <table border="1">
        <tr>
            <th>上映開始時刻</th>
            <th>上映終了時刻</th>
        </tr>
        @foreach ($schedules as $schedule)
        <tr>
            <td>{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}</td>
            <td>{{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</td>
        </tr>
        @endforeach
    </table>
    @endif
</body>

</html>