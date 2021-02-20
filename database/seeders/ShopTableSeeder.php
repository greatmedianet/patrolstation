<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Shop;

class ShopTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        Shop::create([
            'name' => 'Test',
            'email' => 'test@test.com',
            'phone' => '09123456789',
            'photo' => '',
            'address' => 'No.(0), 0 street, yangon, myanmar',
            'short_name' => 'TE',
            'confirmed_nozzle' => '1'
        ]);
    }
}