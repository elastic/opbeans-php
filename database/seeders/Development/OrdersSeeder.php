<?php

namespace Database\Seeders\Development;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrdersSeeder extends Seeder
{
    public function run()
    {
        $handle = fopen(__DIR__.'/Data/orders.csv', 'r');

        if (!$handle) {
            return;
        }

        while ($data = fgetcsv($handle)) {
            $insert[] = [
                'id' => $data[0],
                'created_at' => $data[1],
                'customer_id' => $data[2],
            ];
        }

        foreach (array_chunk($insert, 100, true) as $chunkData) {
            DB::table('orders')->insert($chunkData);
        }

        fclose($handle);
    }
}
