<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FILMAX - Movies</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/MoviesPage.css') }}">
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
                <span>Dashboard</span>
            </a>

            <a href="{{ route('AdminMovies') }}" class="nav-link active">
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

    <main class="movies-page">
        <header class="movies-header">
            <div>
                <h1>Movies</h1>
                <p>Manage all movies in FILMAX</p>
            </div>

            <a href="{{ route('AdminAddMovies') }}" class="add-movie-btn">
                <span>+</span> Add Movie
            </a>
        </header>

        <section class="filters-card">
            <form action="{{ route('AdminMovies') }}" method="GET" class="movies-search-form">
                <div class="search-box">
                    <label for="movie-search">Search Movies</label>
                    <input
                        type="text"
                        id="movie-search"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Enter movie title..."
                    >
                </div>

                <button type="submit" class="search-btn">Search</button>
            </form>
        </section>

        <section class="movies-section">
            <div class="movies-section-header">
                <div>
                    <h2>All Movies</h2>
                    <p>Browse and manage your movie collection</p>
                </div>

                <span class="movies-count">{{ count($movies) }} Movies</span>
            </div>

            @if ($movies->count() > 0)
                <div class="movies-grid">
                    @foreach ($movies as $movie)
                        <article class="movie-card">
                            <div class="movie-poster">
                                <img src="{{ asset('images/' . $movie->poster) }}" alt="{{ $movie->title }}">
                            </div>

                            <div class="movie-content">
                                <div class="movie-top">
                                    <div>
                                        <h3>{{ $movie->title }}</h3>
                                        <span class="movie-id">ID: {{ $movie->id }}</span>
                                    </div>

                                    <span class="movie-status {{ strtolower(str_replace(' ', '-', $movie->status)) }}">
                                        {{ $movie->status }}
                                    </span>
                                </div>

                                <div class="movie-info-grid">
                                    <div class="movie-info-item">
                                        <span class="info-label">Duration</span>
                                        <strong>{{ $movie->duration }} min</strong>
                                    </div>

                                    <div class="movie-info-item">
                                        <span class="info-label">Release Date</span>
                                        <strong>{{ $movie->release_date }}</strong>
                                    </div>

                                    <div class="movie-info-item">
                                        <span class="info-label">Language</span>
                                        <strong>{{ $movie->language }}</strong>
                                    </div>

                                    <div class="movie-info-item">
                                        <span class="info-label">Age Rating</span>
                                        <strong>{{ $movie->age_rating }}</strong>
                                    </div>
                                </div>

                                <div class="movie-description">
                                    <span class="info-label">Description</span>
                                    <p>{{ $movie->description }}</p>
                                </div>

                                <div class="movie-actions">
                                    <a href="{{ route('AdminMoviesEdit', $movie->id) }}" class="action-btn edit-btn">
                                        Edit
                                    </a>

                                    <button
                                        type="button"
                                        class="action-btn delete-btn"
                                        onclick="openDeleteModal('{{ $movie->id }}', '{{ addslashes($movie->title) }}')"
                                    >
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="movies-not-found">
                    <div class="not-found-icon">M</div>
                    <h3>Movie Not Found</h3>
                    <p>No movie found matching "{{ request('search') }}"</p>
                </div>
            @endif

            <div class="pagination-wrapper">
                @if ($movies->onFirstPage())
                    <span class="disabled">‹</span>
                @else
                    <a href="{{ $movies->previousPageUrl() }}">‹</a>
                @endif

                @foreach ($movies->getUrlRange(1, $movies->lastPage()) as $page => $url)
                    @if ($page == $movies->currentPage())
                        <span class="active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach

                @if ($movies->hasMorePages())
                    <a href="{{ $movies->nextPageUrl() }}">›</a>
                @else
                    <span class="disabled">›</span>
                @endif
            </div>
        </section>
    </main>

    <div class="delete-modal" id="deleteModal">
        <div class="delete-modal-box">
            <div class="delete-modal-icon">!</div>
            <h3>Delete Movie?</h3>
            <p>Are you sure you want to delete <strong id="deleteMovieName"></strong>?</p>

            <div class="delete-modal-actions">
                <button type="button" class="cancel-delete-btn" onclick="closeDeleteModal()">
                    Cancel
                </button>

                <form id="deleteMovieForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="confirm-delete-btn">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById('deleteModal');
    const movieName = document.getElementById('deleteMovieName');
    const deleteForm = document.getElementById('deleteMovieForm');

    function openDeleteModal(movieId, movieTitle) {
        movieName.textContent = movieTitle;
        deleteForm.action = `/Admin/Movies/${movieId}`;
        modal.classList.add('show');
        document.body.classList.add('modal-open');
    }

    function closeDeleteModal() {
        modal.classList.remove('show');
        document.body.classList.remove('modal-open');
    }

    modal.addEventListener('click', function(e) {
        if (e.target === this) closeDeleteModal();
    });
</script>
</body>
</html>