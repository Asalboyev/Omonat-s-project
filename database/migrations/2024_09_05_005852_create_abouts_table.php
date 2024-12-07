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
        Schema::create('abouts', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable();
            $table->text('subtitle')->nullable();
            $table->string('apple_link')->nullable();
            $table->string('and_link')->nullable();
            $table->string('app_link')->nullable();
            $table->string(column: 'phone')->nullable();
            $table->text('description')->nullable();
            $table->text('double_description')->nullable();
            $table->string('insta_link')->nullable();
            $table->string('tg_link')->nullable();
            $table->string('you_link')->nullable();


            $table->timestamps();
        });

        DB::table('abouts')->insert([
            'description'=> '{"uz":"<p>efwefwfewfwe<\/p>","ru":"<p>fwfwefwfwef<\/p>"}'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abouts');
    }
};
