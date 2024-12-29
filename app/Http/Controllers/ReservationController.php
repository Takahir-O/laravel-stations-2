<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Movie;
use App\Models\Sheet;
use App\Models\Schedule;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    // 座席予約フォーム表示
    public function create(request $request,$movie_id,$schedule_id)
    {
        // クエリパラメータから日付と座席IDを取得
        $date = $request->query('date');
        $sheetId = $request->query('sheet_id');

        // 日付か座席IDが取得できない場合はエラーを返す
        if(!$date || !$sheetId){
            return redirect()->back()->withErrors(['date' => '日付と座席IDは必須です。']);
        }

        // 映画、スケジュール、座標の情報を取得
        $movie = Movie::findOrFail($movie_id);
        $schedule = Schedule::findOrFail($schedule_id);
        $sheet = Sheet::findOrFail($sheetId);

        return view(
            'reservations.create',
            compact('movie','schedule','sheet','date')
        )
    }

    /**
     *  予約情報を登録する
     *
     *  リクエストされたデータをもとに、予約情報をデータベースに登録します。
     *  具体的には、以下の処理を行います。
     *  1. リクエストデータのバリデーション:
     *     - schedule_id, sheet_id, name, email, date が必須であることを確認します。
     *     - schedule_id, sheet_id は整数型であることを確認します。
     *     - name は文字列型であることを確認します。
     *     - email はメールアドレス形式であることを確認します。
     *     - date は日付形式であることを確認します。
     *  2. 既存予約の確認:
     *     - 指定された schedule_id, sheet_id, date の組み合わせで、既に予約が存在するかどうかをデータベースで確認します。
     *     - 予約が既に存在する場合は、エラーメッセージと共に映画詳細ページにリダイレクトします。
     *  3. 予約情報の登録:
     *     - 予約が存在しない場合、リクエストされたデータを基に新しい予約情報をデータベースに登録します。
     *     - 登録に失敗した場合は、エラーメッセージと共に前のページにリダイレクトします。
     *  4. 予約完了後のリダイレクト:
     *     - 予約が正常に完了した場合、成功メッセージと共に映画詳細ページにリダイレクトします。
     *
     */
    public function store(Request $request)
    {
        // バリデーションルールを定義
        // schedule_id: 必須、整数
        // sheet_id: 必須、整数 
        // name: 必須、文字列
        // email: 必須、メールアドレス形式
        // date: 必須、日付形式
        $request->validate([
            'schedule_id' => 'required|integer',
            'sheet_id' => 'required|integer',
            'name' => 'required|string',
            'email' => 'required|email',
            'date' => 'required|date',
        ]);

        // リクエストから各項目を取得
        $scheduleId = $request->input('schedule_id');
        $sheetId = $request->input('sheet_id');
        $date = $request->input('date');

        // 指定された日付、スケジュールID、座席IDの組み合わせで
        // 既存の予約が存在するかチェック
        $existReservation = Reservation::where('schedule_id',$scheduleId)
            ->where('sheet_id',$sheetId)
            ->where('date',$date)
            ->exists();
        
        // もし指定されたスケジュールID、座席ID、日付の組み合わせで予約が既に存在する場合
        if($existReservation){
            // スケジュールIDから映画を取得
            $movie = Schedule::find($scheduleId)->movie;
            // 映画詳細ページにリダイレクトし、エラーメッセージを表示
            return redirect("/movies/{$movie->id}/schedules/{$scheduleId}/sheets?date={$date}")
                ->withErrors(['reservation' => '選択された座席は既に予約されています。']);
        }

        try{
            Reservation::create($request->all());
        }catch(\Exception $e){
            return redirect()->back()->withErrors(['error' => '予約に失敗しました。']);
        }

        $movie = Schedule::find($scheduleId)->movie;
        return redirect("/movies/{$movie->id}")->with('success','予約が完了しました。');
    }
}
