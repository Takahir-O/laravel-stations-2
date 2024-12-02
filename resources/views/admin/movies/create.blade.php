<!DOCTYPE html>
<html>

<head>
    <title>映画の新規登録</title>
</head>

<body>
    <h1>映画の新規登録</h1>

    @if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ url('admin/movies/store') }}" method="POST">
        @csrf
        <div>
            <label for="title">映画タイトル</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}">
        </div>
        <div>
            <label for="image_url">画像URL</label>
            <input type="text" name="image_url" id="image_url" value="{{ old('image_url') }}">
        </div>
        <div>
            <label for="published_year">公開年</label>
            <input type="text" name="published_year" id="published_year" value="{{ old('published_year') }}">
        </div>
        <div>
            <label for="is_showing">公開中かどうか</label>
            <input type="hidden" name="is_showing" value="off">
            <input type="checkbox" name="is_showing" id="is_showing" value="on" {{ old('is_showing') === 'on' ? 'checked' : '' }}>
        </div>
        <div>
            <label for="description">概要</label>
            <textarea name="description" id="description">{{ old('description') }}</textarea>
        </div>
        <div>
            <button type="submit">登録</button>
        </div>
    </form>
</body>

</html>