<!DOCTYPE html>
<html>

<head>
    <title>映画の編集</title>
</head>

<body>
    <h1>映画の編集</h1>

    @if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{url('admin/movies/' .$movie->id .'/update')}}" method="POST">
        @csrf
        @method('patch')

        <div>
            <label for="title">映画タイトル</label>
            <input type="text" name="title" id="title" value="{{old('title',$movie->title)}}">
        </div>

        <div>
            <label for="image_url">画像URL</label>
            <input type="text" name="image_url" id="image_url" value="{{ old('image_url', $movie->image_url) }}">
        </div>
        <div>
            <label for="published_year">公開年</label>
            <input type="text" name="published_year" id="published_year" value="{{ old('published_year', $movie->published_year) }}">
        </div>
        <div>
            <label for="is_showing">公開中かどうか</label>
            <input type="checkbox" name="is_showing" id="is_showing" value="1" {{ old('is_showing') == 1 ? 'checked' : '' }}>
            <input type="hidden" name="is_showing" value="0">
        </div>
        <div>
            <label for="description">概要</label>
            <textarea name="description" id="description">{{ old('description', $movie->description) }}</textarea>
        </div>
        <div>
            <button type="submit">更新</button>
        </div>

        <div>
            <a href="{{ route('admin.movies.index') }}">戻る</a>
        </div>
    </form>

</body>

</html>