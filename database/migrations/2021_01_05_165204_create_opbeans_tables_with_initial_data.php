<?php

/** @noinspection PhpUnused */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class CreateOpbeansTablesWithInitialData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Log::critical(__CLASS__. '::' . __FUNCTION__ . ' entered');

        DB::statement(
        /** @lang sql */ <<<'____________TAG'
            CREATE TABLE customers (
                id INTEGER NOT NULL,
                full_name VARCHAR(1000) NOT NULL,
                company_name VARCHAR(1000) NOT NULL,
                email VARCHAR(1000) NOT NULL,
                address VARCHAR(1000) NOT NULL,
                postal_code VARCHAR(1000) NOT NULL,
                city VARCHAR(1000) NOT NULL,
                country VARCHAR(1000) NOT NULL,
                PRIMARY KEY (id)
            );
____________TAG
        );

        DB::statement(
        /** @lang sql */ <<<'____________TAG'
            CREATE TABLE order_lines (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                order_id INTEGER NOT NULL,
                amount INTEGER NOT NULL,
                product_id INTEGER NOT NULL
            );
____________TAG
        );

        DB::statement(
        /** @lang sql */ <<<'____________TAG'
            CREATE TABLE orders (
                id INTEGER NOT NULL,
                created_at VARCHAR(4000) NOT NULL,
                customer_id INTEGER NOT NULL,
                PRIMARY KEY (id)
            );
____________TAG
        );

        DB::statement(
        /** @lang sql */ <<<'____________TAG'
            CREATE TABLE product_types (
                id INTEGER NOT NULL,
                name VARCHAR(1000) NOT NULL,
                PRIMARY KEY (id)
            );
____________TAG
        );

        DB::statement(
        /** @lang sql */ <<<'____________TAG'
            CREATE TABLE products (
                id INTEGER NOT NULL,
                sku VARCHAR(1000) NOT NULL,
                name VARCHAR(1000) NOT NULL,
                description VARCHAR(4000) NOT NULL,
                stock INTEGER NOT NULL,
                cost INTEGER NOT NULL,
                selling_price INTEGER NOT NULL,
                type_id INTEGER NOT NULL,
                PRIMARY KEY (id)
            );
____________TAG
        );

        throw new \RuntimeException('DUMMY');

        $initialDataFilePath = __DIR__ . 'opbeans_initial_data.sql';
        $initialDataFileContents = file_get_contents($initialDataFilePath);
        if ($initialDataFileContents === false) {
            throw new \RuntimeException('Failed to get contents of the file with opbeans initial data: ' . $initialDataFilePath);
        }
        DB::unprepared($initialDataFileContents);

        Log::critical(__CLASS__. '::' . __FUNCTION__ . ' exiting');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
        Schema::dropIfExists('product_types');
        Schema::dropIfExists('customers');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('order_lines');
    }
}
