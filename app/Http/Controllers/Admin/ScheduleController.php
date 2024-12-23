<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Movie;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log; 

class ScheduleController extends Controller
{
    // スケジュールの一覧表示
    public function index()
    {
        // Scheduleモデルを使用して、全てのスケジュールを取得。グループ化する
        $schedules = Schedule::with('movie')->get()->groupBy('movie_id');
        return view('admin.schedules.index', ['schedules' => $schedules]);
        
    }
    // スケジュールの詳細表示
    public function show($id)
    {
        // Scheduleモデルを使用して、指定されたIDのスケジュールを取得
        $schedule = Schedule::findOrFail($id);
        return view('admin.schedules.show', ['schedule' => $schedule]);
    }
    // スケジュール作成画面
    public function create($id)
    {
        // Movieモデルを使用して、指定されたIDの映画情報を取得
        $movie = Movie::findOrFail($id);
        return view('admin.schedules.create', ['movie' => $movie]);
    }

    // スケジュールの登録処理
    public function store(Request $request, $movieId)
    {
        // バリデーション
        $validator = Validator::make($request->all(), [
            'movie_id' => 'required|exists:movies,id',
            'start_time_date' => 'required|date_format:Y-m-d|before_or_equal:end_time_date',
            'start_time_time' => 'required|date_format:H:i',
            'end_time_date' => 'required|date_format:Y-m-d|after_or_equal:start_time_date',
            'end_time_time' => 'required|date_format:H:i',
        ]);

        // バリデーションエラーがあればリダイレクト
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // 開始日時と終了日時を作成
        $startDateTime = $request->start_time_date . ' ' . $request-> start_time_time;
        $endDateTime = $request->end_time_date . ' ' . $request-> end_time_time;

        // Carbon を使用して日時を比較
        $startTime = Carbon::createFromFormat('Y-m-d H:i', $startDateTime);
        $endTime = Carbon::createFromFormat('Y-m-d H:i', $endDateTime);

        // デバッグ出力: 開始時刻と終了時刻 (コンソール出力)
        Log::info('Start Time: ' . $startTime);
        Log::info('End Time: ' . $endTime);

        // 開始日時と終了日時の差を計算
        $diffInMinutes = $startTime->diffInMinutes($endTime);

        // デバッグ出力: 開始日時と終了日時の差 (コンソール出力)
        error_log('Difference in Minutes: ' . $diffInMinutes);


        // 開始日時と終了日時の差が5分未満の場合のチェック
        if ($startTime->diffInMinutes($endTime) < 6) {
            $validator->errors()->add('start_time_time', '開始日時と終了日時の差は5分以上にしてください。');
            $validator->errors()->add('end_time_time', '開始日時と終了日時の差は5分以上にしてください。');

            // セッション情報をデバッグ
            error_log('Session Data: ' . json_encode(session()->all()));
            // フォームの入力値をデバッグ
            error_log('Input Data: ' . json_encode($request->all()));
            return redirect()->back()->withErrors($validator)->withInput();
        }


        try {
            // スケジュールを作成
            Schedule::create([
                'movie_id' => $movieId,
                'start_time' => $startTime,
                'end_time' => $endTime,
            ]);
            return redirect()->route('admin.schedules.index')->with('success', 'スケジュールを登録しました');
        } catch (\Exception $e) {
            // エラーメッセージをセッションに格納してリダイレクト
            return redirect()->route('admin.schedules.index')->with('error', 'スケジュールの登録に失敗しました');
        }
    }

    public function edit($id)
    {
        // Scheduleモデルを使用して、指定されたIDのスケジュールを取得
        $schedule = Schedule::findOrFail($id);
        // 開始日時と終了日時を日付と時間に分割
        $start_date = $schedule->start_time->format('Y-m-d');
        $start_time = $schedule->start_time->format('H:i');
        $end_date = $schedule->end_time->format('Y-m-d');
        $end_time = $schedule->end_time->format('H:i');

        return view('admin.schedules.edit', [
            'schedule' => $schedule,
            'start_date' => $start_date,
            'start_time' => $start_time,
            'end_date' => $end_date,
            'end_time' => $end_time,
        ]);
    }

    public function update(Request $request, $id)
    {
        // バリデーション
        $request->validate(
            [
                'movie_id' => 'required|exists:movies,id',
                'start_time_date' => 'required|date_format:Y-m-d|before_or_equal:end_time_date',
                'start_time_time' => 'required|date_format:H:i|before:end_time_time',
                'end_time_date' => 'required|date_format:Y-m-d|after_or_equal:start_time_date',
                'end_time_time' => 'required|date_format:H:i|after:start_time_time',
            ]
        );

        // $startTime = $request->start_time_date . ' ' . $request->start_time_time . ':00';
        // $endTime = $request->end_time_date . ' ' . $request->end_time_time . ':00';

        // 開始日時と終了日時を作成
        $startDateTime = $request->start_time_date . ' ' . $request->start_time_time;
        $endDateTime = $request->end_time_date . ' ' . $request->end_time_time;

        // Carbon を使用して日時を比較
        $startTime = Carbon::createFromFormat('Y-m-d H:i', $startDateTime);
        $endTime = Carbon::createFromFormat('Y-m-d H:i', $endDateTime);

        if ($startTime->diffInMinutes($endTime) < 6 ) {
            return redirect()
                ->back()
                ->withErrors(['start_time_time' => '開始日時と終了日時の差は5分以上にしてください。'])
                ->withInput();
        }

        try {
            // スケジュールを更新
            $schedule = Schedule::findOrFail($id);
            $schedule->movie_id = $request->movie_id;
            $schedule->start_time = $startTime;
            $schedule->end_time = $endTime;
            $schedule->save();

            return redirect()->route('admin.schedules.index')->with('success', 'スケジュールを更新しました');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'スケジュールの更新に失敗しました');
        }
    }

    // スケジュールの削除処理
    public function destroy($id)
    {
        // Retrieve the schedule
        $schedule = Schedule::findOrFail($id);

        // Delete the schedule
        $schedule->delete();

        return redirect()->route('admin.schedules.index')->with('success', 'スケジュールを削除しました');
    }
}
