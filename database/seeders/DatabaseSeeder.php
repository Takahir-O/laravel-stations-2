<?php

namespace Database\Seeders;

use App\Practice;
use App\Models\Movie;
use Illuminate\Database\Seeder;

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
        Movie::truncate();

        // 新しいデータをシード
        Movie::factory(50)->create();
    }
}
