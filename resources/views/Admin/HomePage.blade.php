<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FILMAX - Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
<div class="admin-layout">
    <aside class="admin-sidebar">
        <div class="sidebar-logo">
            <h2>FILMAX</h2>
            <span>ADMIN PANEL</span>
        </div>
        <nav class="sidebar-nav">
            <a href="{{ route('MainAdmin') }}" class="nav-link active">
                <span class="nav-icon">▣</span>
                <span class="nav-label">Dashboard</span>
            </a>
            <a href="{{ route('AdminMovies') }}" class="nav-link">
                <span class="nav-icon">M</span>
                <span class="nav-label">Movies</span>
            </a>
            <a href="{{ route('AdminHalls') ?? '#' }}" class="nav-link">
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

    <main class="dashboard-page">
        <header class="dashboard-header">
            <div>
                <h1>Dashboard</h1>
                <p>Welcome back, Admin</p>
            </div>
            <div class="admin-profile">
                <div class="admin-avatar">
                    {{ $userAvatar ?? 'A' }}
                </div>
                <div class="profile-info">
                    <span>Administrator</span>
                    <small>Admin</small>
                </div>
            </div>
        </header>

        <section class="stats-grid">
            <div class="stat-card">
                <div class="stat-top">
                    <span>Movies</span>
                    <div class="stat-icon">M</div>
                </div>
                <h2>{{ $moviesCount }}</h2>
                <p>Movies available</p>
            </div>
            <div class="stat-card">
                <div class="stat-top">
                    <span>Users</span>
                    <div class="stat-icon">U</div>
                </div>
                <h2>{{ $usersCount }}</h2>
                <p>Registered users</p>
            </div>
            <div class="stat-card">
                <div class="stat-top">
                    <span>Bookings</span>
                    <div class="stat-icon">B</div>
                </div>
                <h2>{{ $bookingsCount }}</h2>
                <p>Total bookings</p>
            </div>
            <div class="stat-card">
                <div class="stat-top">
                    <span>Revenue</span>
                    <div class="stat-icon">$</div>
                </div>
                <h2>${{ number_format($totalRevenue, 2) }}</h2>
                <p>Total revenue</p>
            </div>
        </section>

        <section class="content-card revenue-card">
            <div class="section-header">
                <div>
                    <h3>Revenue Overview</h3>
                    <p>Revenue during the last 7 days</p>
                </div>
                <strong>${{ number_format(array_sum($last7Days), 2) }}</strong>
            </div>
            <div class="chart-container">
                <div class="chart-values">
                    <span>${{ number_format($maxRevenue) }}</span>
                    <span>${{ number_format($maxRevenue * 0.66) }}</span>
                    <span>${{ number_format($maxRevenue * 0.33) }}</span>
                    <span>$0</span>
                </div>
                <div class="chart-area">
                    <div class="grid-lines">
                        <div class="grid-line"></div>
                        <div class="grid-line"></div>
                        <div class="grid-line"></div>
                        <div class="grid-line"></div>
                    </div>
                    <div class="bars">
                        @foreach ($revenueChart as $date => $percentage)
                            <div class="bar-item">
                                <div class="bar" style="height: {{ $percentage }}%" data-tooltip="${{ number_format($last7Days[$date] ?? 0, 2) }}"></div>
                                <span>{{ \Carbon\Carbon::parse($date)->format('D') }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <div class="main-grid">
            <section class="content-card bookings-card">
                <div class="section-header">
                    <div>
                        <h3>Recent Bookings</h3>
                        <p>Latest customer bookings</p>
                    </div>
                    <a href="/admin/bookings" class="link-btn">View All</a>
                </div>
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Movie</th>
                                <th>Showtime</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentBookings as $booking)
                                <tr>
                                    <td>{{ $booking->user->name }}</td>
                                    <td>{{ $booking->showTime->movie->title }}</td>
                                    <td>{{ $booking->showTime->start_at }}</td>
                                    <td>${{ number_format($booking->total_price, 2) }}</td>
                                    <td>
                                        <span class="status {{ strtolower($booking->status) }}">
                                            {{ $booking->status }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>

            <div class="right-column">
                <section class="content-card">
                    <div class="section-header">
                        <div>
                            <h3>Popular Movies</h3>
                            <p>Most booked movies</p>
                        </div>
                        <a href="/admin/movies" class="link-btn">View All</a>
                    </div>
                    <div class="item-list">
                        @foreach ($popularMovies as $movie)
                            <div class="item-row">
                                <span class="item-title">{{ $movie->title }}</span>
                                <strong class="item-badge">{{ $movie->bookings_count }} bookings</strong>
                            </div>
                        @endforeach
                    </div>
                </section>

                <section class="content-card">
                    <div class="section-header">
                        <div>
                            <h3>Upcoming Showtimes</h3>
                            <p>Next scheduled screenings</p>
                        </div>
                        <a href="/admin/showtimes" class="link-btn">View All</a>
                    </div>
                    <div class="item-list">
                        @foreach ($upcomingShowTimes as $showTime)
                            <div class="item-row">
                                <div>
                                    <strong class="item-title">{{ $showTime->movie->title }}</strong>
                                    <span class="item-sub">{{ $showTime->start_at->format('d M Y') }}</span>
                                </div>
                                <time class="time-highlight">{{ $showTime->start_at->format('h:i A') }}</time>
                            </div>
                        @endforeach
                    </div>
                </section>
            </div>
        </div>
    </main>
</div>
</body>
</html>