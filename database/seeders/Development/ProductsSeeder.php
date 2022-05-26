<?php

namespace Database\Seeders\Development;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    public function run()
    {
        $handle = fopen(__DIR__.'/Data/products.csv', 'r');

        if (!$handle) {
            return;
        }

        while ($data = fgetcsv($handle)) {
            $insert[] = [
                'id' => $data[0],
                'sku' => $data[1],
                'name' => $data[2],
                'description' => $data[3],
                'stock' => $data[4],
                'cost' => $data[5],
                'selling_price' => $data[6],
                'type_id' => $data[7],
            ];
        }

        foreach (array_chunk($insert, 100, true) as $chunkData) {
            DB::table('products')->insert($chunkData);
        }

        fclose($handle);
    }
}
