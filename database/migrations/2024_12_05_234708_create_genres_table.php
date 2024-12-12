<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('genres', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        //どのジャンルに属するかを示す情報を追加する
        Schema::table('movies', function (Blueprint $table) {
            $table->foreignId('genre_id') //映画がどのジャンルに属するかを示す番号
                ->constrained('genres') //ジャンル表の番号と一致する必要
                ->onDelete('cascade'); //ジャンルそのものを消すと、そのジャンルに属する映画も消す
                
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->dropForeign(['genre_id']);
            $table->dropColumn('genre_id');
        });

        Schema::dropIfExists('genres');
    }
};
