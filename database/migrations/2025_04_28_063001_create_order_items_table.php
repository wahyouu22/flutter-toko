<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('product_name');
            $table->decimal('price', 12, 2);
            $table->integer('quantity');
            $table->decimal('berat', 8, 2);
            $table->decimal('total_price', 12, 2);
            $table->timestamps();

            // Foreign key for orders (ensure this runs after orders table exists)
            $table->foreign('order_id')
                  ->references('id')
                  ->on('orders')
                  ->onDelete('cascade');

            // Only add product foreign key if products table exists
            if (Schema::hasTable('products')) {
                $table->foreign('product_id')
                      ->references('id')
                      ->on('products')
                      ->onDelete('set null');
            }
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_items');
    }
};
