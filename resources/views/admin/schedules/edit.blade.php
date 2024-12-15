@extends('layouts.admin')

@section('content')
<h1>スケジュール編集</h1>
<h2>作品名: {{ $schedule->movie->title }}</h2>

<form action="{{route('admin.schedules.update',$schedule->id)}}" method="POST">
    @csrf
    @method('PATCH')
    <input type="hidden" name="movie_id" value="{{ $schedule->movie_id }}">
    <div>
        <label for="start_time_date">開始日付:</label>
        <input type="date" id="start_time_date" name="start_time_date" value="{{ $start_date }}" required>
    </div>
    <div>
        <label for="start_time_time">開始時間:</label>
        <input type="time" id="start_time_time" name="start_time_time" value="{{$start_time}}" required>
    </div>
    <div>
        <label for="end_time_date">終了日付:</label>
        <input type="date" id="end_time_date" name="end_time_date" value="{{$end_date}}" required>
    </div>
    <div>
        <label for="end_time_time">終了時間:</label>
        <input type="time" id="end_time_time" name="end_time_time" value="{{$end_time}}" required>
    </div>
    <button type="submit">更新</button>

</form>