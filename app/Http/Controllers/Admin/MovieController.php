<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;
use App\Models\Movie;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log; // この行を追加


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
            'title' => 'required|string|unique:movies',
            'image_url' => 'required|url',
            'published_year' => 'required|integer|min:1900|max:2100',
            'is_showing' => 'required',
            'description' => 'required|string|max:1000',
            'genre' => 'required|string|max:255',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $genre = Genre::firstOrCreate(['name' => $request->input('genre')]);

                Movie::create([
                    'title' => $request->input('title'),
                    'image_url' => $request->input('image_url'),
                    'published_year' => $request->input('published_year'),
                    'is_showing' => $request->boolean('is_showing'),
                    'description' => $request->input('description'),
                    'genre_id' => $genre->id,
                ]);
            });
            return redirect()->route('admin.movies.index')->with('success', '新しい映画を登録しました');
        } catch (\Exception $e) {
            abort(500, '映画の登録に失敗しました');
        }
    }

    // editアクションを追加
    public function edit($id)
    {
        // 編集対象の映画を取得
        $movie = Movie::find($id);
        return view('admin.movies.edit', ['movie' => $movie]);
        // edit.blade.phpを表示の際に$movieの情報をmovieという名前で渡す
    }

    public function update(Request $request, $id)
    {
        // リクエストの内容を受け取り、更新するMovieモデルを取得
        $movie = Movie::findOrFail($id);

        // バリデーション
        $request->validate([
            'title' => 'required|string|unique:movies,title,' . $id,
            'image_url' => 'required|url',
            'published_year' => 'required|integer|min:1900|max:2100',
            'is_showing' => 'required',
            'description' => 'required|string|max:1000',
            'genre' => 'required|string|max:255',
        ]);

        try {
            DB::transaction(function () use ($request, $movie) {
                $genre = Genre::firstOrCreate(['name' => $request->input('genre')]);

                $movie->update([
                    'title' => $request->input('title'),
                    'image_url' => $request->input('image_url'),
                    'published_year' => $request->input('published_year'),
                    'is_showing' => $request->boolean('is_showing'),
                    'description' => $request->input('description'),
                    'genre_id' => $genre->id,
                ]);
            });

            return redirect()->route('admin.movies.index')->with('success', '映画情報を更新しました');
        } catch (\Exception $e) {
            abort(500, '映画情報の更新に失敗しました');
        }
    }

    public function destroy($id)
    {
        // 削除対象の映画を取得
        $movie = Movie::findOrFail($id);
        $movie->delete();

        return redirect()->route('admin.movies.index')->with('success', '映画情報を削除しました');
    }
}
