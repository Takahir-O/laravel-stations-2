<!DOCTYPE html>
<html>

<head>
    <title>Movies Admin</title>
</head>

<body>
    <h1>Movies List</h1>


    @if (session('success'))
    <div>
        {{ session('success') }}
    </div>
    @endif

    @if (session('error'))
    <div>
        {{ session('error') }}
    </div>
    @endif


    <table border="1">
        <tr>
            <th>ID</th>
            <th>映画タイトル</th>
            <th>ジャンル</th>
            <th>画像URL</th>
            <th>公開年</th>
            <th>上映中かどうか</th>
            <th>概要</th>
            <th>登録日時</th>
            <th>更新日時</th>
            <th>操作</th>
        </tr>
        @foreach ($movies as $movie)
        <tr>
            <td>{{ $movie->id }}</td>
            <td>{{ $movie->title }}</td>
            <td>{{ $movie->genre->name }}</td>
            <td>{{ $movie->image_url }}</td>
            <td>{{ $movie->published_year }}</td>
            <td>{{ $movie->is_showing ? '上映中' : '上映予定' }}</td>
            <td>{{ $movie->description }}</td>
            <td>{{ $movie->created_at }}</td>
            <td>{{ $movie->updated_at }}</td>
            <td>
                <form action="{{ route('admin.movies.destroy', $movie->id) }}" method="POST" onsubmit="return confirm('「{{ $movie->title }}」を削除してもよろしいですか？\nこの操作は取り消せません。');">
                    @csrf
                    @method('delete')
                    <button type="submit">削除</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</body>

</html>