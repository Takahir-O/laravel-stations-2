<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>スケジュール詳細 - Movies Admin</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <!-- カスタムCSS -->
    <style>
        body {
            padding-top: 70px;
        }
    </style>
</head>

<body>
    <!-- ナビゲーションバー -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <a class="navbar-brand" href="#">管理者ダッシュボード</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.schedules.index') }}">スケジュール一覧</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.movies.index') }}">映画一覧</a>
                </li>
                <!-- 他のナビゲーションリンクをここに追加 -->
            </ul>
        </div>
    </nav>

    <!-- メインコンテンツ -->
    <div>
        <!-- 開始時刻・終了時刻の表示 -->
        <h1 class="mb-4">スケジュール詳細</h1>
        <div class="card mb-4">
            <div class="card-header">
                作品ID: {{ $schedule->movie->id }} - 作品名: {{ $schedule->movie->title }}
            </div>
            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
            <div class="card-body">
                <p><strong>開始日時:</strong> {{ $schedule->start_time->format('Y年m月d日') }}</p>
                <p><strong>開始時刻:</strong> {{ $schedule->start_time->format('H:i') }}</p>
                <p><strong>終了日時:</strong> {{ $schedule->end_time->format('Y年m月d日') }}</p>
                <p><strong>終了時刻:</strong> {{ $schedule->end_time->format('H:i') }}</p>
                <p><strong>作成日時:</strong> {{ $schedule->created_at }}</p>
                <p><strong>更新日時:</strong> {{ $schedule->updated_at }}</p>
            </div>

            <div class="card-footer">
                <a href="{{ route('admin.schedules.edit', $schedule->id) }}" class="btn btn-primary">編集</a>
                <form action="{{ route('admin.schedules.destroy', $schedule->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" onclick="return confirm('本当に削除しますか？')">削除</button>
                </form>
                <a href="{{ route('admin.schedules.index') }}" class="btn btn-secondary">戻る</a>

            </div>
</body>