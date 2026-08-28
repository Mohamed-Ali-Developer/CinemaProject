<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Booking;
use App\Models\ShowTime;
use App\Models\Hall;
use App\Models\Seat;
use App\Models\Movie;

use App\Http\Requests\BookingRequest;

use App\Http\Resources\ShowTimeResource;
use App\Http\Resources\SeatResource;
use App\Http\Resources\BookingsResource;


class BookingController extends Controller
{
    public function Booking(Movie $movie){
        $showtimes = ShowTime::with([
            'hall.cinema'
        ])
        ->where('movie_id', $movie->id)
        ->where('status', 'scheduled')
        ->orderBy('start_at')
        ->get();
        return ShowTimeResource::collection($showtimes);
    }

    public function show(Hall $hall, ShowTime $showtime){

        $showtime->bookings()
            ->where('status', 'pending')
            ->where('created_at', '<=', now()->subMinutes(10))
            ->update([
                'status' => 'cancelled',
            ]);

        $seats = $hall->seats;
        $prices = $showtime->ticketPrices
            ->keyBy('seat_type');

        $bookedSeatIds = [];

        $bookings = $showtime->bookings()
            ->whereIn('status', ['pending', 'confirmed'])
            ->with('seats')
            ->get();

            foreach ($bookings as $booking) {
                foreach ($booking->seats as $seat) {
                    if (!in_array($seat->id, $bookedSeatIds)) {
                        $bookedSeatIds[] = $seat->id;
                    }
                }
            }

            foreach ($seats as $seat) {
                $seat->ticket_price =
                    $prices[$seat->type]->price ?? null;

                $seat->booking_status =
                    in_array($seat->id, $bookedSeatIds)
                        ? 'booked'
                        : 'available';
            }
        
        return SeatResource::collection($seats);
    }

    public function store(BookingRequest $request){

        $showtime = ShowTime::with([
            'ticketPrices',
            'bookings.seats',
        ])->findOrFail($request->show_time_id);

        $seats = Seat::whereIn('id', $request->seats)
            ->where('hall_id', $showtime->hall_id)
            ->get();

        $unavailableSeats = $seats->where(
            'status',
            '!=',
            'available'
        );

        if ($unavailableSeats->isNotEmpty()) {
            return response()->json([
                'message' => 'One or more selected seats are not available.',ذ
            ], 422);
        }

        $bookedSeatIds = [];
        $bookings = $showtime->bookings()
            ->whereIn('status', ['pending', 'confirmed'])
            ->with('seats')
            ->get();

        foreach ($bookings as $booking) {
            foreach ($booking->seats as $seat) {
                if (!in_array($seat->id, $bookedSeatIds)) {
                    $bookedSeatIds[] = $seat->id;
                }
            }
        }
        $alreadyBooked = $seats->whereIn(
            'id',
            $bookedSeatIds
        );
        if ($alreadyBooked->isNotEmpty()) {
            return response()->json([
                'message' => 'One or more selected seats are already booked.',
            ], 422);
        }
        $prices = $showtime->ticketPrices
            ->keyBy('seat_type');
        $totalPrice = 0;
        foreach ($seats as $seat) {
            $price = $prices[$seat->type]->price ?? null;
            if ($price === null) {
                return response()->json([
                    'message' => "Price not found for seat type: {$seat->type}."
                ], 422);
            }
            $totalPrice += $price;
        }

        $booking = Booking::create([
            'user_id' => $request->user()->id,
            'show_time_id' => $showtime->id,
            'total_price' => $totalPrice,
            'status' => 'pending',
            'booked_at' => now(),
        ]);

        foreach ($seats as $seat) {
            $booking->seats()->attach($seat->id);
        }

        return response()->json([
            'message' => 'Booking created successfully.',
            'booking_id' => $booking->id,
            'status' => $booking->status,
            'total_price' => $booking->total_price,
        ], 201);
    }

    public function confirm(Request $request){
        $booking = Booking::where('id', $request->booking_id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        if ($booking->status !== 'pending') {
            return response()->json([
                'message' => 'This booking cannot be confirmed.'
            ], 422);
        }

        if ($booking->created_at->addMinutes(10)->isPast()) {
            $booking->update([
                'status' => 'cancelled',
            ]);
            return response()->json([
                'message' => 'This booking has expired.'
            ], 422);
        }

        $booking->update([
            'status' => 'confirmed',
        ]);
        return response()->json([
            'message' => 'Booking confirmed successfully.',
            'booking_id' => $booking->id,
            'status' => $booking->status,
            'total_price' => $booking->total_price,
        ]);
    }


    public function index(Request $request){
        $user = $request->user();
        $bookings = Booking::where('user_id', $user->id)
            ->with([
                'showTime.movie',
                'showTime.hall.cinema',
                'seats'
            ])
            ->latest('booked_at')
            ->get();
        return BookingsResource::collection($bookings);
    }

    public function destroy(Request $request, Booking $booking){
        $user = $request->user();
        if ($booking->user_id !== $user->id) {
            return response()->json([
                'message' => 'You are not authorized to cancel this booking.'
            ], 403);
        }
        $booking->update([
            'status' => 'cancelled'
        ]);
        return response()->json([
            'message' => 'Booking cancelled successfully'
        ]);
    }
}
