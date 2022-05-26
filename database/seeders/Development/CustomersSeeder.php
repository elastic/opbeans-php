<?php

namespace Database\Seeders\Development;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomersSeeder extends Seeder
{
    public function run()
    {
        $handle = fopen(__DIR__.'/Data/customers.csv', 'r');

        if (!$handle) {
            return;
        }

        while ($data = fgetcsv($handle)) {
            $insert[] = [
                'id' => $data[0],
                'full_name' => $data[1],
                'company_name' => $data[2],
                'email' => $data[3],
                'address' => $data[4],
                'postal_code' => $data[5],
                'city' => $data[6],
                'country' => $data[7],
            ];
        }

        foreach (array_chunk($insert, 100, true) as $chunkData) {
            DB::table('customers')->insert($chunkData);
        }

        fclose($handle);
    }
}
