<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AddMovieRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'poster' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'duration' => 'required|integer|min:1',
            'release_date' => 'required|date',
            'description' => 'nullable|string',
            'language' => 'required|string|max:255',
            'status' => 'required|string|in:coming_soon,showing,ended',
            'age_rating' => 'nullable|string|in:G,PG,PG-13,R,NC-17',
            'genres' => 'required|array|min:1',
            'genres.*' => 'required|integer|exists:genres,id',
        ];
    }
}
