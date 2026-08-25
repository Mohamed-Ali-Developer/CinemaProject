<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FILMAX - Halls Management</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/HallsMain.css') }}">
</head>

<body>
<div class="admin-layout">
    <aside class="admin-sidebar">
        <div class="sidebar-logo">
            <h2>FILMAX</h2>
            <span>ADMIN PANEL</span>
        </div>

        <nav class="sidebar-nav">
            <a href="{{ route('MainAdmin') }}" class="nav-link">
                <span class="nav-icon">▣</span>
                <span class="nav-label">Dashboard</span>
            </a>

            <a href="{{ route('AdminMovies') }}" class="nav-link">
                <span class="nav-icon">M</span>
                <span class="nav-label">Movies</span>
            </a>

            <a href="{{ route('AdminHalls') ?? '#' }}" class="nav-link active">
                <span class="nav-icon">H</span>
                <span class="nav-label">Halls</span>
            </a>

            <a href="{{ route('AdminShowtimes') ?? '#' }}" class="nav-link">
                <span class="nav-icon">S</span>
                <span class="nav-label">Showtimes</span>
            </a>

            <a href="{{ route('AdminBookings') ?? '#' }}" class="nav-link">
                <span class="nav-icon">B</span>
                <span class="nav-label">Bookings</span>
            </a>
        </nav>

        <div class="sidebar-bottom">
            <form action="{{ route('Logout') ?? '#' }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">
                    <span class="nav-icon">↪</span>
                    <span class="nav-label">Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <main class="main-content">
        <header class="page-header">
            <div class="header-meta">
                <span class="page-subtitle">Cinema Halls Management</span>
                <h1 class="cinema-title">{{ $cinema->name }}</h1>
                <p class="halls-count">Managing halls & seating capacities</p>
            </div>

            <div class="header-actions">
                <a href="{{ route('AdminAddHalls', ['cinema_id' => $cinema->id]) }}" class="add-btn">
                    + Add Hall
                </a>
            </div>
        </header>

        <div class="filters">
            <div class="filter-group">
                <label for="cinema_id">Select Cinema:</label>

                <form method="GET">
                    <select name="cinema_id" id="cinema_id" onchange="this.form.submit()">
                        @foreach ($cinemas as $item)
                            <option value="{{ $item->id }}" {{ $cinema->id == $item->id ? 'selected' : '' }}>
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>

        <div class="halls-grid">
            @forelse ($halls as $hall)
                <div class="hall-card">
                    <div class="hall-top">
                        <span class="hall-id">#{{ $hall->id }}</span>

                        <span class="status {{ $hall->status }}">
                            ● {{ ucfirst($hall->status) }}
                        </span>
                    </div>

                    <div class="hall-info">
                        <h2>{{ $hall->name }}</h2>
                        <span class="hall-type">{{ $hall->type }}</span>
                    </div>

                    <div class="capacity">
                        <span>Capacity</span>
                        <strong>{{ $hall->capacity }} Seats</strong>
                    </div>

                    <div class="hall-actions">
                        <a href="#">View</a>
                        <a href="{{ route('AdmineditHalls', $hall->id) }}">Edit</a>

                        <form
                            action="{{ route('AdmindestroyHalls', $hall->id) }}"
                            method="POST"
                            style="display: inline;"
                            onsubmit="return confirm('Are you sure you want to delete this hall?');"
                        >
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="delete-link">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="not-found">
                    No halls found for this cinema.
                </div>
            @endforelse
        </div>

        <div class="pagination">
            {{ $halls->links() }}
        </div>
    </main>
</div>
</body>
</html>