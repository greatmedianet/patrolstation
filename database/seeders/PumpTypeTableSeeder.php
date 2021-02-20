<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\PumpType;

class PumpTypeTableSeeder extends Seeder
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
        DB::table('pump_types')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $pump_types = [
            ['name' => '1 Nozzle', 'description' => 'test', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['name' => '2 Nozzles', 'description' => 'test', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['name' => '4 Nozzles', 'description' => 'test', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['name' => '6 Nozzles', 'description' => 'test', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['name' => '8 Nozzles', 'description' => 'test', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
        ];

        PumpType::insert($pump_types);
    }
}
