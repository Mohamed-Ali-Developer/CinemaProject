<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Showtime - FILMAX</title>
    <link rel="stylesheet" href="{{ asset('css/AddShowtimeForm.css') }}">
</head>
<body>
<div class="showtime-page">
    <div class="showtime-form-container">
        <div class="showtime-form-header">
            <h1>Edit Showtime</h1>
            <p>Update movie screening schedule</p>
        </div>

        <div class="form-section">
            <form action="{{ route('AdminupdateShowtimes', $showtime->id) }}" method="POST" class="showtime-form">
                @csrf
                @method('PUT')

                <div class="form-grid">
                    <div class="form-group">
                        <label for="movie_id">Movie</label>
                        <select id="movie_id" name="movie_id">
                            <option value="">Select movie</option>
                            @foreach ($movies as $movie)
                                <option value="{{ $movie->id }}" {{ old('movie_id', $showtime->movie_id) == $movie->id ? 'selected' : '' }}>
                                    {{ $movie->title }}
                                </option>
                            @endforeach
                        </select>
                        @error('movie_id')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="hall_id">Cinema & Hall</label>
                        <select id="hall_id" name="hall_id">
                            <option value="">Select cinema & hall</option>
                            @foreach ($halls as $hall)
                                <option value="{{ $hall->id }}" {{ old('hall_id', $showtime->hall_id) == $hall->id ? 'selected' : '' }}>
                                    {{ $hall->cinema->name }} - {{ $hall->name }} ({{ $hall->type }})
                                </option>
                            @endforeach
                        </select>
                        @error('hall_id')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="start_date">Start Date</label>
                        <input type="date" id="start_date" name="start_date" value="{{ old('start_date', $showtime->start_at->format('Y-m-d')) }}">
                        @error('start_date')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="start_time">Start Time</label>
                        <input type="time" id="start_time" name="start_time" value="{{ old('start_time', $showtime->start_at->format('H:i')) }}">
                        @error('start_time')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="end_time">End Time</label>
                        <input type="time" id="end_time" name="end_time" value="{{ old('end_time', $showtime->end_at->format('H:i')) }}">
                        @error('end_time')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="regular_price">Regular Price</label>
                        <input type="number" id="regular_price" name="regular_price" value="{{ old('regular_price', $showtime->ticketPrices->where('seat_type', 'regular')->first()->price ?? '') }}" placeholder="Enter regular price" min="0" step="0.01">
                        @error('regular_price')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="vip_price">VIP Price</label>
                        <input type="number" id="vip_price" name="vip_price" value="{{ old('vip_price', $showtime->ticketPrices->where('seat_type', 'vip')->first()->price ?? '') }}" placeholder="Enter VIP price" min="0" step="0.01">
                        @error('vip_price')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('AdminShowtimes') }}" class="cancel-btn">Cancel</a>
                    <button type="submit" class="submit-btn">Update Showtime</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>