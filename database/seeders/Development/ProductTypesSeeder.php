<?php

namespace Database\Seeders\Development;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductTypesSeeder extends Seeder
{
    public function run()
    {
        $handle = fopen(__DIR__.'/Data/product_types.csv', 'r');

        if (!$handle) {
            return;
        }

        while ($data = fgetcsv($handle)) {
            $insert[] = [
                'id' => $data[0],
                'name' => $data[1],
            ];
        }

        foreach (array_chunk($insert, 100, true) as $chunkData) {
            DB::table('product_types')->insert($chunkData);
        }

        fclose($handle);
    }
}
