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
            <!-- タイトルまたは概要で検索するための入力フィールド -->
            <input type="text"
                name="keyword"
                value="{{ $keyword }}"
                placeholder="タイトルまたは概要で検索">
        </div>

        {{-- 表示状態選択 --}}
        <div>
            <label>
                <!-- 全ての映画を表示するラジオボタン -->
                <input type="radio"
                    name="is_showing"
                    value="all"
                    {{ $is_showing === 'all' ? 'checked' : '' }}>
                すべて
            </label>
            <label>
                <!-- 上映中の映画を表示するラジオボタン -->
                <input type="radio"
                    name="is_showing"
                    value="1"
                    {{ $is_showing === '1' ? 'checked' : '' }}>
                上映中
            </label>
            <label>
                <!-- 上映予定の映画を表示するラジオボタン -->
                <input type="radio"
                    name="is_showing"
                    value="0"
                    {{ $is_showing === '0' ? 'checked' : '' }}>
                上映予定
            </label>
        </div>

        <!-- 検索ボタン -->
        <button type="submit">検索</button>
    </form>

    {{-- 映画リスト --}}
    <div>
        <!-- 映画のリストをループで表示 -->
        @foreach($movies as $movie)
        <div>
            <!-- 映画のタイトル -->
            <h2>{{ $movie->title }}</h2>
            <!-- 映画の画像 -->
            <img src="{{ $movie->image_url }}" alt="{{ $movie->title }}">
            <!-- 映画の公開年 -->
            <p>公開年: {{ $movie->published_year }}</p>
            <!-- 映画の上映状態 -->
            <p>状態: {{ $movie->is_showing ? '上映中' : '上映予定' }}</p>
            <!-- 映画の概要 -->
            <p>概要: {{ $movie->description }}</p>
        </div>
        @endforeach
    </div>

    {{-- ページネーション --}}
    {{ $movies->links() }}
</body>

</html>