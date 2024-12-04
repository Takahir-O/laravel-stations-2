<!DOCTYPE html>
<html>

<head>
    <title>Movies</title>
</head>

<body>
    <h1>映画一覧</h1>
    <form action="{{ route('movies.index') }}" method="GET">
        {{-- 検索フォーム --}}
        <div>
            <input type="text"
                name="keyword"
                value="{{ $keyword }}"
                placeholder="タイトルまたは概要で検索">
        </div>

        {{-- 表示状態選択 --}}
        <div>
            <label>
                <input type="radio"
                    name="is_showing"
                    value="all"
                    {{ $is_showing === 'all' ? 'checked' : '' }}>
                すべて
            </label>
            <label>
                <input type="radio"
                    name="is_showing"
                    value="1"
                    {{ $is_showing === '1' ? 'checked' : '' }}>
                上映中
            </label>
            <label>
                <input type="radio"
                    name="is_showing"
                    value="0"
                    {{ $is_showing === '0' ? 'checked' : '' }}>
                上映予定
            </label>
        </div>

        <button type="submit">検索</button>
    </form>

    {{-- 映画リスト --}}
    <div>
        @foreach($movies as $movie)
        <div>
            <h2>{{ $movie->title }}</h2>
            <img src="{{ $movie->image_url }}" alt="{{ $movie->title }}">
            <p>公開年: {{ $movie->published_year }}</p>
            <p>状態: {{ $movie->is_showing ? '上映中' : '上映予定' }}</p>
            <p>概要: {{ $movie->description }}</p>
        </div>
        @endforeach
    </div>

    {{-- ページネーション --}}
    {{ $movies->links() }}
</body>

</html>