<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ShopTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(PumpTypeTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(AdjustmentTypeSeeder::class);
        $this->call(BusinessTypeSeeder::class);
        $this->call(SupplierTypeSeeder::class);
    }
}
