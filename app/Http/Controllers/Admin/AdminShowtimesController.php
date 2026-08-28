<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddShowtimeRequest;
use App\Models\TicketPrice;
use Illuminate\Http\Request;
use App\Models\ShowTime;
use App\Models\Cinema;
use App\Models\Movie;
use App\Models\Hall;

class AdminShowtimesController extends Controller
{
    public function index(Request $request)
    {
        $query = ShowTime::with([
            'movie',
            'hall.cinema'
        ]);
        if ($request->filled('search')) {
            $query->whereHas('movie', function ($q) use ($request) {
                $q->where(
                    'title',
                    'like',
                    '%' . $request->search . '%'
                );
            });
        }
        if ($request->filled('cinema_id')) {
            $query->whereHas('hall', function ($q) use ($request) {
                $q->where('cinema_id', $request->cinema_id);
            });
        }
        $query->orderBy('start_at', 'asc');
        $showtimes = $query->paginate(10)->withQueryString();
        $cinemas = Cinema::orderBy('name')->get();
        return view(
            'Admin.Showtimes.ShowtimesMain',
            compact('showtimes', 'cinemas')
        );
    }

    public function show(){
        $movies = Movie::orderBy('title')->get();
        $halls = Hall::with('cinema')
            ->where('status', 'active')
            ->get();
        return view(
            'Admin.Showtimes.AddShowtimeForm',
            compact('movies', 'halls')
        );
    }

     public function store(AddShowtimeRequest $request){
        $showtime = Showtime::create([
            'movie_id' => $request->movie_id,
            'hall_id' => $request->hall_id,
            'start_at' => $request->start_date . ' ' . $request->start_time,
            'end_at' => $request->start_date . ' ' . $request->end_time,
        ]);

        TicketPrice::create([
            'show_time_id' => $showtime->id,
            'seat_type' => 'regular',
            'price' => $request->regular_price,
        ]);

        TicketPrice::create([
            'show_time_id' => $showtime->id,
            'seat_type' => 'vip',
            'price' => $request->vip_price,
        ]);
        return redirect()
            ->route('AdminShowtimes')
            ->with('success', 'Showtime added successfully.');
    }

    public function edit($id){
        $showtime = Showtime::with('ticketPrices')->findOrFail($id);
        $movies = Movie::orderBy('title')->get();
        $halls = Hall::with('cinema')
            ->where('status', 'active')
            ->get();
        return view(
            'Admin.Showtimes.EditShowtimeForm',
            compact('showtime', 'movies', 'halls')
        );
    }

    public function update(AddShowtimeRequest $request, $id){
        $showtime = Showtime::findOrFail($id);
        $showtime->update([
            'movie_id' => $request->movie_id,
            'hall_id' => $request->hall_id,
            'start_at' => $request->start_date . ' ' . $request->start_time,
            'end_at' => $request->start_date . ' ' . $request->end_time,
        ]);

        $showtime->ticketPrices()
            ->where('seat_type', 'regular')
            ->update([
                'price' => $request->regular_price,
            ]);

        $showtime->ticketPrices()
            ->where('seat_type', 'vip')
            ->update([
                'price' => $request->vip_price,
            ]);
        return redirect()
            ->route('AdminShowtimes')
            ->with('success', 'Showtime updated successfully.');
    }

    public function destroy($id){
        $showtime = Showtime::findOrFail($id);
        $showtime->delete();
        return redirect()
            ->route('AdminShowtimes')
            ->with('success', 'Showtime deleted successfully.');
    }
}
