<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\SupplierType;

class SupplierTypeSeeder extends Seeder
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
        DB::table('supplier_types')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $supplier_types = [
          	['name' => 'Wholesalers', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['name' => 'Importers', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['name' => 'Other', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
        ];

        SupplierType::insert($supplier_types);
    }
}
