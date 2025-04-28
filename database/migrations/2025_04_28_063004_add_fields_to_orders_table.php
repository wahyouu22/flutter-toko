<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('resi')->nullable()->after('status');
            $table->text('address')->nullable()->after('resi');
            $table->string('pos_code', 10)->nullable()->after('address');
            $table->string('phone', 20)->nullable()->after('pos_code');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['resi', 'address', 'pos_code', 'phone']);
        });
    }
};
