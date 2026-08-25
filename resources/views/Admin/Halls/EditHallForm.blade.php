<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Hall - FILMAX</title>
    <link rel="stylesheet" href="{{ asset('css/AddHallForm.css') }}">
</head>

<body>

<div class="hall-page">
    <div class="hall-form-container">

        <div class="hall-form-header">
            <h1>Edit Hall</h1>
            <p>Edit hall in {{ $cinema->name }}</p>
        </div>

        <div class="form-section">
            <form
                action="{{ route('AdminupdateHalls', $hall->id) }}"
                method="POST"
                enctype="multipart/form-data"
                class="hall-form"
            >
                @csrf
                @method('PUT')

                <div class="form-grid">

                    <div class="form-group">
                        <label for="name">Hall Name</label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            placeholder="Enter hall name"
                            value="{{ old('name', $hall->name) }}"
                        >

                        @error('name')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="type">Hall Type</label>

                        <select id="type" name="type">
                            <option value="">Select hall type</option>

                            <option value="2D" {{ old('type', $hall->type) == '2D' ? 'selected' : '' }}>
                                2D
                            </option>

                            <option value="3D" {{ old('type', $hall->type) == '3D' ? 'selected' : '' }}>
                                3D
                            </option>

                            <option value="IMAX" {{ old('type', $hall->type) == 'IMAX' ? 'selected' : '' }}>
                                IMAX
                            </option>

                            <option value="VIP" {{ old('type', $hall->type) == 'VIP' ? 'selected' : '' }}>
                                VIP
                            </option>
                        </select>

                        @error('type')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="capacity">Capacity</label>

                        <input
                            type="number"
                            id="capacity"
                            name="capacity"
                            placeholder="Enter seats capacity"
                            value="{{ old('capacity', $hall->capacity) }}"
                        >

                        @error('capacity')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>

                        <select id="status" name="status">
                            <option value="active" {{ old('status', $hall->status) == 'active' ? 'selected' : '' }}>
                                Active
                            </option>

                            <option value="inactive" {{ old('status', $hall->status) == 'inactive' ? 'selected' : '' }}>
                                Inactive
                            </option>
                        </select>

                        @error('status')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                <div class="form-actions">
                    <a href="{{ route('AdminHalls') }}" class="cancel-btn">
                        Cancel
                    </a>

                    <button type="submit" class="submit-btn">
                        Update Hall
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>

</body>
</html>