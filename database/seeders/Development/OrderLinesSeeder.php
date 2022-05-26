<?php

namespace Database\Seeders\Development;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderLinesSeeder extends Seeder
{
    public function run()
    {
        $handle = fopen(__DIR__.'/Data/order_lines.csv', 'r');

        if (!$handle) {
            return;
        }

        while ($data = fgetcsv($handle)) {
            $insert[] = [
                'id' => $data[0],
                'order_id' => $data[1],
                'amount' => $data[2],
                'product_id' => $data[3],
            ];
        }

        foreach (array_chunk($insert, 100, true) as $chunkData) {
            DB::table('order_lines')->insert($chunkData);
        }

        fclose($handle);
    }
}
