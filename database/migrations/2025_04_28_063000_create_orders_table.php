<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('customer_name');
            $table->string('customer_email');
            $table->decimal('total_price', 12, 2);
            $table->decimal('shipping_cost', 12, 2);
            $table->decimal('final_price', 12, 2);
            $table->string('shipping_service');
            $table->string('shipping_etd');
            $table->string('destination_city');
            $table->string('status')->default('pending');
            $table->string('resi')->nullable();
            $table->text('address')->nullable();
            $table->string('pos_code', 10)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('foto_resi')->nullable(); // <--- Tambahan baru
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
