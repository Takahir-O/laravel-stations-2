<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>スケジュール一覧 - Movies Admin</title>
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
    <div class="container">
        <h1 class="mb-4">スケジュール一覧</h1>

        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif

        @foreach($schedules as $movieId => $movieSchedules)
        <div class="card mb-4">
            <div class="card-header">
                作品ID: {{ $movieSchedules->first()->movie->id }} - 作品名: {{ $movieSchedules->first()->movie->title }}
            </div>
            <div class="card-body">
                <a href="{{ route('admin.movies.show', $movieId) }}" class="btn btn-primary">映画詳細ページへ</a>
                <a href="{{ route('admin.schedules.create', $movieId) }}" class="btn btn-success">スケジュール追加</a>
            </div>
            <ul class="list-group list-group-flush">
                @foreach($movieSchedules as $schedule)
                <li class="list-group-item">
                    <a href="{{ route('admin.schedules.show', $schedule->id) }}">
                        開始時刻: {{ $schedule->start_time->format('Y-m-d H:i') }} -
                        終了時刻: {{ $schedule->end_time->format('Y-m-d H:i') }}
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
        @endforeach
    </div>

    <!-- Bootstrap JS と依存関係 -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>

</html>