<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookings - FILMAX</title>
    <link rel="stylesheet" href="{{ asset('css/BookingsMain.css') }}">
</head>

<body>

    <aside class="admin-sidebar">
        <div class="sidebar-logo">
            <h2>FILMAX</h2>
            <span>ADMIN PANEL</span>
        </div>

        <nav class="sidebar-nav">
            <a href="{{ route('MainAdmin') }}" class="nav-link">
                <span class="nav-icon">▣</span>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('AdminMovies') }}" class="nav-link">
                <span class="nav-icon">M</span>
                <span>Movies</span>
            </a>
            <a href="{{ route('AdminHalls') }}" class="nav-link">
                <span class="nav-icon">H</span>
                <span>Halls</span>
            </a>
            <a href="{{ route('AdminShowtimes') }}" class="nav-link">
                <span class="nav-icon">S</span>
                <span>Showtimes</span>
            </a>
            <a href="{{ route('AdminBookings') }}" class="nav-link active">
                <span class="nav-icon">B</span>
                <span>Bookings</span>
            </a>
        </nav>

        <div class="sidebar-bottom">
            <form action="{{ route('Logout') ?? '#' }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">
                    <span class="nav-icon">↪</span>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <div class="bookings-page">

        <div class="bookings-header">
            <div>
                <h1>Bookings</h1>
                <p>Manage customer reservations and booking details</p>
            </div>
        </div>

        <div class="filters-section">
            <form action="{{ route('AdminBookings') }}" method="GET" class="filters-form">
                
                <div class="search-group">
                    <input type="text" name="search" placeholder="Search booking..." value="{{ request('search') }}">
                </div>

                <div class="filter-group">
                    <select name="cinema_id">
                        <option value="">All Cinemas</option>
                        @foreach ($cinemas as $cinema)
                            <option value="{{ $cinema->id }}" {{ request('cinema_id') == $cinema->id ? 'selected' : '' }}>
                                {{ $cinema->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-group">
                    <select name="status">
                        <option value="">All Status</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <button type="submit" class="filter-btn">Search</button>
            </form>
        </div>

        <div class="booking-stats">
            <div class="stat-card">
                <span class="stat-label">Total Bookings</span>
                <strong class="stat-value">{{ $totalBookings }}</strong>
            </div>

            <div class="stat-card confirmed">
                <span class="stat-label">Confirmed</span>
                <strong class="stat-value">{{ $confirmedBookings }}</strong>
            </div>

            <div class="stat-card pending">
                <span class="stat-label">Pending</span>
                <strong class="stat-value">{{ $pendingBookings }}</strong>
            </div>

            <div class="stat-card cancelled">
                <span class="stat-label">Cancelled</span>
                <strong class="stat-value">{{ $cancelledBookings }}</strong>
            </div>
        </div>

        <div class="table-container">
            <table class="bookings-table">
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Customer</th>
                        <th>Movie</th>
                        <th>Cinema</th>
                        <th>Hall</th>
                        <th>Showtime</th>
                        <th>Seats</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bookings as $booking)
                        <tr>
                            <td><span class="booking-id">{{ $booking->id }}</span></td>
                            
                            <td>
                                <div class="customer-name">{{ $booking->user->name ?? 'N/A' }}</div>
                                <div class="customer-email">{{ $booking->user->email ?? '' }}</div>
                            </td>

                            <td><span class="movie-title">{{ $booking->showTime->movie->title ?? 'N/A' }}</span></td>

                            <td><span class="cinema-name">{{ $booking->showTime->hall->cinema->name ?? 'N/A' }}</span></td>

                            <td><span class="hall-name">{{ $booking->showTime->hall->name ?? 'N/A' }}</span></td>

                            <td>
                                <div class="showtime-cell">
                                    <span>{{ optional($booking->showTime->start_at)->format('M d, Y') }}</span>
                                    <small>{{ optional($booking->showTime->start_at)->format('h:i A') }}</small>
                                </div>
                            </td>

                            <td>
                                <div class="seats-list">
                                    @forelse ($booking->seats as $seat)
                                        <span class="seat">{{ $seat->row }}{{ $seat->number }}</span>
                                    @empty
                                        <span class="no-seats">—</span>
                                    @endforelse
                                </div>
                            </td>

                            <td>
                                <span class="total-price">${{ number_format($booking->total_price, 2) }}</span>
                            </td>

                            <td>
                                <span class="booking-status {{ strtolower($booking->status) }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>

                            <td>
                                <div class="table-actions">
                                    <form action="{{ route('AdmindestroyBookings', $booking->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-btn">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="empty-state">No bookings found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination">
            {{ $bookings->links() }}
        </div>

    </div>

</body>
</html>