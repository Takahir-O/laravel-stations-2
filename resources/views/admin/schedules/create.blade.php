@extends('layouts.admin')

@section('content')

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<h1>スケジュール追加</h1>
<h2>作品名: {{ $movie->title }}</h2>
<form action="{{ route('admin.schedules.store', $movie->id) }}" method="POST">
    @csrf
    <!-- 隠しフィールドとして movie_id を追加 -->
    <input type="hidden" name="movie_id" value="{{ $movie->id }}">

    <div class="form-group">
        <label for="start_time_date">開始日付:</label>
        <input type="date" id="start_time_date" name="start_time_date" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="start_time_time">開始時間:</label>
        <input type="time" id="start_time_time" name="start_time_time" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="end_time_date">終了日付:</label>
        <input type="date" id="end_time_date" name="end_time_date" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="end_time_time">終了時間:</label>
        <input type="time" id="end_time_time" name="end_time_time" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">追加</button>
</form>
@endsection