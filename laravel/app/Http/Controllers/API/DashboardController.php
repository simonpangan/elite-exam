<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Artist;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __invoke()
    {
        //Interviewee Notes: Can use laravel api resource … elected not to do it
        return response()->json([
            'albums_per_artist' => $this->getAlbumsSalesPerArtists(),
            'combined_albums_per_artist' => $this->getCombinedAlbumsPerArtists(),
            'top_artist' => $this->getTopOneArtist(),

            //Interview Notes:I'm not sure if you guys want this on the same route /dashboard
            'albums_of_search_artist' => $this->getAlbumsOfSearchArtist()
        ]);
    }

    private function getAlbumsSalesPerArtists(): Collection
    {
        return Artist::query()
             ->select(['id', 'name'])
             ->with('albums:id,artist_id,name,sales,year')
             ->get()
             ->map(function ($artist) {
                 return [
                     'artist' => $artist->name,
                     'albums' => $artist->albums->map(function ($album) {
                         return [
                             'name'  => $album->name,
                             'sales' => $album->sales,
                             'year'  => $album->year
                         ];
                     })
                 ];
             });
    }

    private function getCombinedAlbumsPerArtists(): Collection
    {
        return Album::query()
            ->join('artists', 'albums.artist_id', '=', 'artists.id')
            ->select('artists.name as artist', DB::raw('SUM(albums.sales) as total_sales'))
            ->groupBy('artists.name')
            ->get();
    }

    private function getTopOneArtist():Collection
    {
        //Alternative: use Rank() window function to get the top artist
        //to accommodate for the possibility of multiple artists having the same total sales

        return Album::query()
            ->join('artists', 'albums.artist_id', '=', 'artists.id')
            ->select('artists.name as artist', DB::raw('SUM(albums.sales) as total_sales'))
            ->groupBy('artists.name')
            ->orderByDesc('total_sales')
            ->limit(1)
            ->get();
    }

    private function getAlbumsOfSearchArtist() {
        return Album::query()
             ->whereRelation('artist', 'name', 'like', '%'.request()->artist.'%')
            ->get()
            ->map(function ($album) {
                return [
                    'name'  => $album->name,
                    'sales' => $album->sales,
                    'year'  => $album->year
                ];
            });
    }
}
