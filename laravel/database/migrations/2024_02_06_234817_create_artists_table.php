<?php

use App\Models\Artist;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('artists', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        //get all artist in album_sales and insert to the artists table
        $artists = DB::table('album_sales')
             ->select(['artist'])->distinct()->get();

        $artists = $artists->map(function ($artist) {
            return [
                'name' => $artist->artist,
                'created_at' => now(),
                'updated_at' => now()
            ];
        });

        Artist::insert($artists->toArray());
    }

    public function down(): void
    {
        Schema::dropIfExists('artists');
    }
};
