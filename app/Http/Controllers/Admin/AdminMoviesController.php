<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AddMovieRequest;
use App\Models\Movie;
use App\Models\Genre;


class AdminMoviesController extends Controller
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
        $movies = $query->paginate(6);
        return view('Admin.Movies.MoviesPage', compact('movies'));
    }

    public function show(){
        $genres = Genre::orderBy('name')->get([
            'id',
            'name'
        ]);
        $statuses = [
            'coming_soon' => 'Coming Soon',
            'showing' => 'Showing',
            'ended' => 'Ended',
        ];
        $ageRatings = [
            'G',
            'PG',
            'PG-13',
            'R',
            'NC-17',
        ];
        return view('Admin.Movies.AddMovieForm', compact(
            'genres',
            'statuses',
            'ageRatings'
        ));
    }

    public function store(AddMovieRequest $request){
        $posterName = null;
        if ($request->hasFile('poster')) {
            $poster = $request->file('poster');
            $posterName = time() . '.' . $poster->getClientOriginalExtension();
            $poster->move(
                public_path('images'),
                $posterName
            );
        }
        $movie = Movie::create([
            'title'        => $request->title,
            'poster'       => $posterName,
            'duration'     => $request->duration,
            'release_date' => $request->release_date,
            'description'  => $request->description,
            'language'     => $request->language,
            'status'       => $request->status,
            'age_rating'   => $request->age_rating,
        ]);
        $movie->genres()->attach($request->genres);
        return redirect()
            ->route('AdminMovies')
            ->with('success', 'Movie added successfully.');
    }

    public function edit(Movie $movie){
        $genres = Genre::orderBy('name')->get([
            'id',
            'name'
        ]);
        $statuses = [
            'coming_soon' => 'Coming Soon',
            'showing' => 'Showing',
            'ended' => 'Ended',
        ];
        $ageRatings = [
            'G',
            'PG',
            'PG-13',
            'R',
            'NC-17',
        ];
        return view('Admin.Movies.movies-edit', compact(
            'movie',
            'genres',
            'statuses',
            'ageRatings'
        ));
    }

    public function update(AddMovieRequest $request, Movie $movie)
    {
        $posterName = $movie->poster;
        if ($request->hasFile('poster')) {
            if ($movie->poster && file_exists(public_path('images/' . $movie->poster))) {
                unlink(public_path('images/' . $movie->poster));
            }
            $poster = $request->file('poster');
            $posterName = time() . '.' . $poster->getClientOriginalExtension();
            $poster->move(
                public_path('images'),
                $posterName
            );
        }

        $movie->update([
            'title'        => $request->title,
            'poster'       => $posterName,
            'duration'     => $request->duration,
            'release_date' => $request->release_date,
            'description'  => $request->description,
            'language'     => $request->language,
            'status'       => $request->status,
            'age_rating'   => $request->age_rating,
        ]);
        $movie->genres()->sync($request->genres ?? []);
        return redirect()
            ->route('AdminMovies')
            ->with('success', 'Movie updated successfully.');
    }

    public function destroy(Movie $movie)
    {
        if ($movie->poster && file_exists(public_path('images/' . $movie->poster))) {
            unlink(public_path('images/' . $movie->poster));
        }
        $movie->delete();
        return redirect()
            ->route('AdminMovies')
            ->with('success', 'Movie deleted successfully.');
    }
}
