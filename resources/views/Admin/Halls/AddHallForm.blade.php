<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Hall - FILMAX</title>

    <link rel="stylesheet" href="{{ asset('css/AddHallForm.css') }}">
</head>

<body>

<div class="hall-page">

    <div class="hall-form-container">

        <div class="hall-form-header">
            <h1>Add Hall</h1>
            <p>
                Add a new hall to {{ $cinema->name }}
            </p>
        </div>

        <div class="form-section">
            <form action="{{ route('AdminstoreHalls') }}" method="POST" class="hall-form">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <input type="hidden" name="cinema_id" value="{{ $cinema->id }}">
                        <label for="name">
                            Hall Name
                        </label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            placeholder="Enter hall name"
                            value="{{ old('name') }}"
                        >
                        @error('name')
                            <span class="error">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="type">
                            Hall Type
                        </label>
                        <select id="type" name="type">
                            <option value="">
                                Select hall type
                            </option>
                            <option
                                value="2D"
                                {{ old('type') == '2D' ? 'selected' : '' }}
                            >
                                2D
                            </option>
                            <option
                                value="3D"
                                {{ old('type') == '3D' ? 'selected' : '' }}
                            >
                                3D
                            </option>
                            <option
                                value="IMAX"
                                {{ old('type') == 'IMAX' ? 'selected' : '' }}
                            >
                                IMAX
                            </option>
                            <option
                                value="VIP"
                                {{ old('type') == 'VIP' ? 'selected' : '' }}
                            >
                                VIP
                            </option>
                        </select>
                        @error('type')
                            <span class="error">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="capacity">
                            Capacity
                        </label>
                        <input
                            type="number"
                            id="capacity"
                            name="capacity"
                            placeholder="Enter seats capacity"
                            value="{{ old('capacity') }}"
                        >
                        @error('capacity')
                            <span class="error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>

                    <div class="form-group">
                        <label for="status">
                            Status
                        </label>
                        <select id="status" name="status">
                            <option
                                value="active"
                                {{ old('status', 'active') == 'active' ? 'selected' : '' }}
                            >
                                Active
                            </option>
                            <option
                                value="inactive"
                                {{ old('status') == 'inactive' ? 'selected' : '' }}
                            >
                                Inactive
                            </option>
                        </select>
                        @error('status')
                            <span class="error">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-actions">
                    <a
                        href="{{ route('AdminHalls') }}"
                        class="cancel-btn"
                    >
                        Cancel
                    </a>
                    <button
                        type="submit"
                        class="submit-btn"
                    >
                        Add Hall
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>