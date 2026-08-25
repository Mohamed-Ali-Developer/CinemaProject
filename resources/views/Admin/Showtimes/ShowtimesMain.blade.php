<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Showtimes - FILMAX</title>
    <link rel="stylesheet" href="{{ asset('css/ShowtimesMain.css') }}">
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
        <a href="{{ route('AdminShowtimes') }}" class="nav-link active">
            <span class="nav-icon">S</span>
            <span>Showtimes</span>
        </a>
        <a href="{{ route('AdminBookings') }}" class="nav-link">
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

<div class="showtimes-page">
    <div class="showtimes-header">
        <div>
            <h1>Showtimes</h1>
            <p>Manage movie screening schedules</p>
        </div>

        <a href="{{ route('AdminAddShowtimes') }}" class="add-showtime-btn">
            + Add Showtime
        </a>
    </div>

    <div class="filters-section">
        <form action="{{ route('AdminShowtimes') }}" method="GET" class="filters-form">
            <div class="search-group">
                <input type="text" name="search" placeholder="Search movie..." value="{{ request('search') }}">
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

            <button type="submit" class="filter-btn">Search</button>
        </form>
    </div>

    <div class="table-container">
        <table class="showtimes-table">
            <thead>
                <tr>
                    <th>Movie</th>
                    <th>Cinema</th>
                    <th>Hall</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($showtimes as $showtime)
                    <tr>
                        <td>
                            <div class="movie-cell">
                                <span class="movie-title">{{ $showtime->movie->title }}</span>
                            </div>
                        </td>

                        <td>{{ $showtime->hall->cinema->name }}</td>

                        <td>
                            <span class="hall-name">{{ $showtime->hall->name }}</span>
                            <span class="hall-type">{{ $showtime->hall->type }}</span>
                        </td>

                        <td>{{ $showtime->start_at->format('M d, Y') }}</td>

                        <td>{{ $showtime->start_at->format('h:i A') }}</td>

                        <td>
                            <div class="table-actions">
                                <a href="{{ route('AdmineditShowtimes', $showtime->id) }}" class="edit-btn">Edit</a>

                                <form action="{{ route('AdmindestroyShowtimes', $showtime->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this showtime?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-btn">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-state">
                            No showtimes found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination">
        {{ $showtimes->links() }}
    </div>
</div>
</body>
</html>