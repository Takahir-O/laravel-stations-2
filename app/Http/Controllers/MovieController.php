<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        // クエリビルダーの初期化
        $query = Movie::query();

        // 公開状態による絞り込み
        if ($request->has('is_showing')) {
            $isShowing = $request->query('is_showing');
            $query->where('is_showing', (bool)$isShowing);
        }

        // キーワード検索（タイトルまたは概要）
        if ($request->filled('keyword')) {
            $keyword = $request->query('keyword');
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'LIKE', "%{$keyword}%")
                ->orWhere('description', 'LIKE', "%{$keyword}%");
            });
        }

        // ページネーション（20件ごと）
        // withQueryString()で現在のクエリパラメータを保持したままページ移動できる
        $movies = $query->paginate(20)->appends($request->all());

        // 検索フォームの初期値を設定
        $params = [
            'movies' => $movies,
            'keyword' => $request->query('keyword', ''),
            'is_showing' => $request->query('is_showing', 'all')
        ];

        return view('movies.index', $params);
    }
}
