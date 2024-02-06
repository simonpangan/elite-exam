<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlbumController extends Controller
{
    public function index()
    {
        return Album::all()->map(function ($album) {
            return [
                'id' => $album->id,
                'name' => $album->name,
                'artist' => $album->artist->name,
                'sales' => $album->sales,
                'year' => $album->year,
                'cover' => asset('storage/uploads/' . $album->cover),
            ];
        });
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'  => ['required'],
            'artist_id' => ['required', 'exists:artists,id'],
            'sales' => ['required', 'integer'],
            'year'  => ['required', 'integer'],
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

         //Store Photo in public
        $photoFileName = null;
        if ($request->hasFile('cover')) {
            $file = $request->file('cover');
            $photoFileName = uniqid().'-'.now()->timestamp.$file->getClientOriginalName();
            $file->storeAs('public/uploads', $photoFileName);
        }

        return Album::create(array_replace($data, [
            'cover' => $photoFileName,
        ]));
    }

    public function show(Album $album)
    {
        return $album;
    }

    public function update(Request $request, Album $album)
    {
        $data = $request->validate([
            'name'  => ['required'],
            'artist_id' => ['required', 'exists:artists,id'],
            'sales' => ['required', 'integer'],
            'year'  => ['required', 'integer'],
            'new_cover' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        $photoFileName = null;
        if ($request->hasFile('new_cover')) {
            //Delete old cover
            Storage::disk('public')->delete("/uploads/{$album->cover}");

            //Store new_photo in public folder
            $file = $request->file('new_cover');
            $photoFileName = uniqid().'-'.now()->timestamp.$file->getClientOriginalName();
            $file->storeAs('public/uploads', $photoFileName);
        }

        $album->update([
            'name' => $data['name'],
            'artist_id' => $data['artist_id'],
            'sales' => $data['sales'],
            'year' => $data['year'],
            'cover' => $photoFileName ?? $album->cover,
        ]);

        return response()->json([
            'message' => 'Album updated successfully.'
        ]);
    }

    public function destroy(Album $album)
    {
        $album->delete();

        return response()->json([
            'message' => 'Album deleted successfully.'
        ]);
    }
}
