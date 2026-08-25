<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Cinema;

class AdminBookingsController extends Controller
{
    public function index(Request $request){
        $query = Booking::with([
            'user',
            'showTime.movie',
            'showTime.hall.cinema',
            'seats'
        ]);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where(
                    'id',
                    'like',
                    "%{$search}%"
                )
                ->orWhereHas('user', function ($q) use ($search) {
                    $q->where(
                        'name',
                        'like',
                        "%{$search}%"
                    );
                })
                ->orWhereHas('showTime.movie', function ($q) use ($search) {
                    $q->where(
                        'title',
                        'like',
                        "%{$search}%"
                    );
                });
            });
        }

        if ($request->filled('cinema_id')) {
            $query->whereHas(
                'showTime.hall',
                function ($q) use ($request) {
                    $q->where(
                        'cinema_id',
                        $request->cinema_id
                    );
                }
            );
        }

        if ($request->filled('status')) {
            $query->where(
                'status',
                $request->status
            );
        }

        $bookings = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $cinemas = Cinema::orderBy('name')->get();
        $totalBookings = Booking::count();
        $confirmedBookings = Booking::where(
            'status',
            'confirmed'
        )->count();
        $pendingBookings = Booking::where(
            'status',
            'pending'
        )->count();
        $cancelledBookings = Booking::where(
            'status',
            'cancelled'
        )->count();
        
        return view(
            'Admin.Booking.BookingsMain',
            compact(
                'bookings',
                'cinemas',
                'totalBookings',
                'confirmedBookings',
                'pendingBookings',
                'cancelledBookings'
            )
        );
    }

    public function destroy(Booking $booking){
        $booking->delete();
        return redirect()
            ->route('AdminBookings')
            ->with('success', 'Booking deleted successfully.');
    }
}
