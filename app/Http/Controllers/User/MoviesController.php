<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\MoviesResource;
use App\Models\Movie;
use App\Models\Genre;

class MoviesController extends Controller
{
    public function index(Request $request){
        $query = Movie::query();
        if ($request->filled('search')) {
            $query->where(
                'title',
                'like',
                '%' . $request->search . '%'
            );
        }

        if ($request->filled('genre')) {
            $query->whereHas('genres', function ($q) use ($request) {
                $q->where('name', $request->genre);
            });
        }
        $movies = $query
            ->with('genres')
            ->orderBy('title')
            ->get();
        return MoviesResource::collection($movies);
    }

    public function show($id){
        $movie = Movie::with([
            'genres',
            'showTimes.hall.cinema'
        ])->findOrFail($id);
        $showtimes = $movie->showTimes->map(function ($showTime) {
            return [
                'start_at' => $showTime->start_at,
                'end_at' => $showTime->end_at,
                'cinema' => $showTime->hall->cinema->name,
                'hall' => $showTime->hall->name,
            ];
        })->values();
        return response()->json([
            'movie' => new MoviesResource($movie),
            'showtimes' => $showtimes
        ]);  
    }

    public function store(Request $request, Movie $movie){
        $user = $request->user();
        $user->movies()->syncWithoutDetaching([
            $movie->id
        ]);
        return response()->json([
            'message' => 'Movie added to My List successfully',
        ], 201);
    }

    public function myList(Request $request){
        $user = $request->user();
        $query = $user->movies();
        if ($request->filled('search')) {
            $query->where(
                'title',
                'like',
                '%' . $request->search . '%'
            );
        }
        if ($request->filled('genre')) {
            $query->whereHas('genres', function ($q) use ($request) {
                $q->where('name', $request->genre);
            });
        }
        $movies = $query
            ->with('genres')
            ->orderBy('title')
            ->get();
        return MoviesResource::collection($movies);
    }

    public function destroy(Request $request, Movie $movie){
        $request->user()
            ->movies()
            ->detach($movie->id);
        return response()->json([
            'message' => 'Movie removed from My List successfully.'
        ]);
    }

}
