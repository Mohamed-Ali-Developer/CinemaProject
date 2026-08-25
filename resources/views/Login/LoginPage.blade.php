<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FILMAX - Admin - Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <main class="login-page">
        <section class="movie-side">
            <img
                src="{{ asset('images/BlackPantherPoster.jpg') }}"
                alt="Black Panther Movie Poster"
                class="movie-image"
            >
            <div class="movie-overlay"></div>
            <div class="movie-content">
                <h1>FILMAX</h1>
                <p>
                    YOUR MOVIE.
                    <span>YOUR EXPERIENCE.</span>
                </p>
            </div>
        </section>

        <section class="login-side">
            <div class="login-container">
                <div class="heading">
                    <h2>
                        Hey Admin,<br>
                        welcome back
                    </h2>
                </div>

                <form action='{{ route("LoginSubmit") }}' method="POST">
                    @csrf

                    @if ($errors->any())
                        <div class="errors">
                            <p>{{ $errors->first() }}</p>
                        </div>
                    @endif

                    <div class="input-group">
                        <label for="email">Email</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            placeholder="Enter your email"
                            autocomplete="email"
                            required
                        >
                        @error('email')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="input-group">
                        <label for="password">Password</label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Enter your password"
                            autocomplete="current-password"
                            required
                        >
                        @error('password')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="login-btn">
                        Login
                    </button>
                </form>
            </div>
        </section>
    </main>
</body>
</html>