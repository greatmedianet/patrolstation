<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Code;

class CodeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Disable Foreign Key Check and Truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('code_generates')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $codes = [
            ['code' => 'ABCDEG', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['code' => 'GHIJKL', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['code' => 'MNOPQR', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
        ];

        Code::insert($codes);
    }
}
