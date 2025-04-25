<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerTable extends Migration
{
    public function up()
{
    Schema::create('customers', function (Blueprint $table) {
        $table->id();
        $table->string('hp')->nullable()->default(null)->change();
        $table->unsignedBigInteger('user_id');
        $table->string('google_id');
        $table->string('google_token');
        $table->string('hp')->nullable();
        $table->string('alamat')->nullable();
        $table->string('pos')->nullable();
        $table->string('foto')->nullable();
        $table->timestamps();

        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
}

    public function down(): void
    {
        Schema::dropIfExists('customer');
    }
};
