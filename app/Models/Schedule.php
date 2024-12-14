<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'movie_id',
        'start_time',
        'end_time',
    ];

    // start_time および end_time カラムを Carbon オブジェクトとして扱うように設定する
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    // Movie モデルとのリレーションを追加
    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }
}
