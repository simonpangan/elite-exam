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
        Schema::create('album_sales', function (Blueprint $table) {
            $table->id();
            $table->string('artist');
            $table->string('album');
            $table->integer('year')->nullable();
            $table->integer('total_sales');
            $table->timestamps();
        });

        DB::unprepared(file_get_contents(__DIR__ . '/../dump/albums.sql'));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
