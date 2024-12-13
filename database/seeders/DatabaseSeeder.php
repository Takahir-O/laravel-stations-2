<?php

namespace Database\Seeders;

use App\Practice;
use App\Models\Movie;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // 追加

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // 既存のデータをクリア
        // 外部キー制約を無効化
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // 既存のデータをクリア
        Movie::truncate();
        DB::table('genres')->truncate(); // 追加

        // SheetsTableSeeder を呼び出す
        $this->call(SheetsTableSeeder::class);

        // 新しいデータをシード
        Movie::factory(50)->create();

        // 外部キー制約を有効化
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
