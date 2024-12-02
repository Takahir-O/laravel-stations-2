<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::all();
        return view('admin.movies.index', ['movies' => $movies]);
    }

    public function show($id)
    {
        $movie = Movie::find($id);
        return view('admin.movies.show', ['movie' => $movie]);
    }

    // createアクションを追加
    public function create()
    {
        // create.blade.phpを表示するだけでOK 引数などは不要
        // dd('create method called');
        return view('admin.movies.create');
    }

    // storeアクションを追加
    public function store(Request $request)
    {
        // リクエストの内容を受け取り、新しいMovieモデルを作成
        $request->validate([
            'title' => 'required|string|max:255|unique:movies',
            'image_url' => 'required|url',
            'published_year' => 'required|integer|min:1900|max:2100',
            'is_showing' => 'required',
            'description' => 'required|string|max:1000',
        ]);

        $movie = new Movie();
        $movie->title = $request->input('title');
        $movie->image_url = $request->input('image_url');
        $movie->published_year = $request->input('published_year');
        $movie->is_showing = $request->input('is_showing') === 'on'; // チェックボックスの値をbooleanに変換
        $movie->description = $request->input('description');
        $movie->save();

        return redirect()->route('admin.movies.index')->with('success', '新しい映画を登録しました');  // ドットを削除
    }


}
