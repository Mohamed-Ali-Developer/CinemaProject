<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\User;
use App\Models\ShowTime;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    public function index(){
        $moviesCount = Movie::count();
        $usersCount = User::where('role', 'user')->count();
        $userAvatar =strtoupper(substr(Auth::user()->name, 0, 1));
        $bookingsCount = Booking::count();
        $totalRevenue = Booking::sum('total_price');

        $revenue = Booking::query()
            ->where('booked_at', '>=', now()->subDays(6)->startOfDay())
            ->selectRaw('DATE(booked_at) as date, SUM(total_price) as total')
            ->groupBy('date')
            ->pluck('total', 'date');
        $last7Days = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $last7Days[$date] = $revenue[$date] ?? 0;
        }
        $maxRevenue = max($last7Days);
        $revenueChart = [];
        foreach ($last7Days as $date => $amount) {
            $revenueChart[$date] = $maxRevenue > 0
                ? ($amount / $maxRevenue) * 100
                : 0;
        }

        $recentBookings = Booking::with([
            'user',
            'showTime.movie'
        ])
        ->latest('booked_at')
        ->take(4)
        ->get();

        $popularMovies = Movie::join(
            'show_times',
            'movies.id',
            '=',
            'show_times.movie_id'
        )
        ->join(
            'bookings',
            'show_times.id',
            '=',
            'bookings.show_time_id'
        )
        ->select(
            'movies.id',
            'movies.title'
        )
        ->selectRaw('COUNT(bookings.id) as bookings_count')
        ->groupBy('movies.id', 'movies.title')
        ->orderByDesc('bookings_count')
        ->take(4)
        ->get();

        $upcomingShowTimes = ShowTime::with('movie')
        ->where('start_at', '>', now())
        ->orderBy('start_at')
        ->take(4)
        ->get();

        return view('Admin.HomePage', compact(
            'moviesCount',
            'usersCount',
            'bookingsCount',
            'totalRevenue',
            'recentBookings',
            'userAvatar',
            'upcomingShowTimes',
            'last7Days',
            'revenueChart',
            'maxRevenue',
            'popularMovies'
        ));
    }
}
