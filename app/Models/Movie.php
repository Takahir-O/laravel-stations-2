<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image_url',
        'published_year',
        'is_showing',
        'description',
        'genre_id'
    ];
    // 一括代入可能なカラムを指定

    // ジャンルとのリレーションを定義
    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }
}
