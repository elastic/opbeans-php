<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 1000);
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('sku', 1000);
            $table->string('name', 1000);
            $table->string('description', 4000);
            $table->unsignedBigInteger('stock');
            $table->unsignedBigInteger('cost');
            $table->unsignedBigInteger('selling_price');
            $table->foreignId('type_id')->constrained('product_types');
        });

        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('company_name');
            $table->string('email');
            $table->string('address');
            $table->string('postal_code');
            $table->string('city');
            $table->string('country');
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('created_at', 4000);
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
        });

        Schema::create('order_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->unsignedBigInteger('amount');
            $table->foreignId('product_id')->constrained('products');
        });
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
};
