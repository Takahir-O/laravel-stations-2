<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        // クエリビルダーの初期化
        // Movieモデルに対するクエリを開始します
        $query = Movie::query();

        // 公開状態による絞り込み
        // リクエストに'is_showing'パラメータが存在する場合、その値に基づいてフィルタリングします
        if ($request->has('is_showing')) {
            $isShowing = $request->query('is_showing');
            // 'is_showing'カラムが指定された値と一致するレコードを取得
            $query->where('is_showing', (bool)$isShowing);
        }

        // キーワード検索（タイトルまたは概要）
        // リクエストに'keyword'パラメータが存在し、値が空でない場合に検索を実行します
        if ($request->filled('keyword')) {
            $keyword = $request->query('keyword');
            // クロージャを使用して、タイトルまたは概要にキーワードが含まれるレコードを取得
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'LIKE', "%{$keyword}%")
                  ->orWhere('description', 'LIKE', "%{$keyword}%");
            });
        }

        // ページネーション（20件ごと）
        // クエリ結果を20件ずつに分割し、現在のリクエストパラメータを保持します
        $movies = $query->paginate(20)->appends($request->all());

        // 検索フォームの初期値を設定
        // ビューに渡すパラメータを配列として準備します
        $params = [
            'movies' => $movies,
            'keyword' => $request->query('keyword', ''),
            'is_showing' => $request->query('is_showing', 'all')
        ];

        // 'movies.index' ビューを返し、パラメータを渡します
        return view('movies.index', $params);
    }
}
