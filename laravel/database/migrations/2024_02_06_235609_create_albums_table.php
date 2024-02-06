<?php

use App\Models\Artist;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('albums', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artist_id');
            $table->string('name');
            $table->unsignedBigInteger('sales');
            $table->year('year');
            $table->string('cover')->nullable();
            $table->timestamps();
        });

        $albums = DB::table('album_sales')->get();

        $albums = $albums->map(function ($album) {
            $artist = Artist::where('name', $album->artist)->first();

            return [
                'artist_id' => $artist->id,
                'name' => $album->album,
                'sales' => $album->total_sales,
                'year' => $album->year,
                'cover' => "placeholder.png",
                'created_at' => now(),
                'updated_at' => now()
            ];
        });

        DB::table('albums')->insert($albums->toArray());

        Schema::dropIfExists('album_sales');
    }

    public function down(): void
    {
        Schema::dropIfExists('albums');
    }
};
