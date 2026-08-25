<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FILMAX - Add Movie</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/AddMovieForm.css') }}">
</head>
<body>
<main class="create-page">
    <header class="create-header">
        <div>
            <span class="page-label">FILMAX ADMIN</span>
            <h1>Add Movie</h1>
            <p>Add a new movie to your FILMAX collection</p>
        </div>
    </header>

    <form action="{{ route('AdminStoreMovies') }}" method="POST" enctype="multipart/form-data" class="movie-form">
        @csrf

        <section class="form-section">
            <div class="section-title">
                <h2>Movie Information</h2>
                <p>Enter the basic information about the movie</p>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label for="title">Movie Title</label>
                    <input type="text" id="title" name="title" placeholder="Enter movie title">
                </div>

                <div class="form-group">
                    <label for="duration">Duration</label>
                    <div class="input-with-unit">
                        <input type="number" id="duration" name="duration" placeholder="120" min="1">
                        <span>min</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="release_date">Release Date</label>
                    <input type="date" id="release_date" name="release_date">
                </div>

                <div class="form-group">
                    <label for="language">Language</label>
                    <input type="text" id="language" name="language" placeholder="English">
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status">
                        <option value="">Select status</option>
                        @foreach ($statuses as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="age_rating">Age Rating</label>
                    <select id="age_rating" name="age_rating">
                        <option value="">Select age rating</option>
                        @foreach ($ageRatings as $ageRating)
                            <option value="{{ $ageRating }}">{{ $ageRating }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group full-width">
                <label>Genres</label>
                <div class="genres-container">
                    @foreach ($genres as $genre)
                        <label class="genre-option">
                            <input type="checkbox" name="genres[]" value="{{ $genre->id }}">
                            <span class="genre-label">{{ $genre->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="form-group full-width">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="5" placeholder="Write a short description about the movie..."></textarea>
            </div>
        </section>

        <section class="form-section">
            <div class="section-title">
                <h2>Movie Poster</h2>
                <p>Upload the poster image for this movie</p>
            </div>

            <div class="poster-upload" id="posterUpload">
                <div class="upload-icon" id="uploadIcon">+</div>

                <div class="upload-content">
                    <label for="poster" id="uploadLabel">Choose Poster</label>
                    <p id="uploadText">PNG, JPG or JPEG</p>
                </div>

                <input type="file" id="poster" name="poster" accept=".png,.jpg,.jpeg,.webp">
            </div>
        </section>

        <div class="form-actions">
            <a href="{{ route('AdminMovies') }}" class="cancel-btn">Cancel</a>
            <button type="submit" class="submit-btn">Add Movie</button>
        </div>
    </form>
</main>

<script>
    const posterInput = document.getElementById('poster');
    const posterUpload = document.getElementById('posterUpload');
    const uploadIcon = document.getElementById('uploadIcon');
    const uploadLabel = document.getElementById('uploadLabel');
    const uploadText = document.getElementById('uploadText');

    posterInput.addEventListener('change', function () {
        if (this.files.length > 0) {
            const file = this.files[0];
            uploadIcon.textContent = '✓';
            uploadIcon.classList.add('uploaded');
            uploadLabel.textContent = 'Poster Selected';
            uploadText.textContent = file.name;
            posterUpload.classList.add('uploaded');
        }
    });
</script>
</body>
</html>