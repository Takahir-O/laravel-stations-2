<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Movie;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    // スケジュールの一覧表示
    public function index()
    {
        // Scheduleモデルを使用して、全てのスケジュールを取得。グループ化する
        $schedules = Schedule::with('movie')->get()->groupBy('movie_id');
        return view('admin.schedules.index', ['schedules' => $schedules]);
    }
}
