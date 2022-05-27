<?php

namespace Database\Seeders;

use Database\Seeders\Development\CustomersSeeder;
use Database\Seeders\Development\OrderLinesSeeder;
use Database\Seeders\Development\OrdersSeeder;
use Database\Seeders\Development\ProductsSeeder;
use Database\Seeders\Development\ProductTypesSeeder;
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
        $this->call(ProductTypesSeeder::class);
        $this->call(ProductsSeeder::class);
        $this->call(CustomersSeeder::class);
        $this->call(OrdersSeeder::class);
        $this->call(OrderLinesSeeder::class);
    }
}
