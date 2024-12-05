<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('zayavkas', function (Blueprint $table) {
    $table->integer('product_id')->nullable()->after('phone_number');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('zayavkas', function (Blueprint $table) {
            //
        });
    }
};