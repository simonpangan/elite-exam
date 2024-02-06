<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    public function index()
    {
        return Artist::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required'],
        ]);

        return Artist::create($data);
    }

    public function show(Artist $artist)
    {
        return $artist;
    }

    public function update(Request $request, Artist $artist)
    {
        $data = $request->validate([
            'name' => ['required'],
        ]);

        $artist->update($data);

        return response()->json([
            'message' => 'Artist updated successfully.'
        ]);
    }
    public function destroy(Artist $artist)
    {
        $artist->delete();

        return response()->json([
            'message' => 'Artist deleted successfully.'
        ]);
    }
}
