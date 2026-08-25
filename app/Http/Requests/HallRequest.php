<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class HallRequest extends FormRequest
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
            'cinema_id' => 'required|exists:cinemas,id',
            'name' => 'required|string|max:100',
            'type' => 'required|in:2D,3D,IMAX,VIP',
            'capacity' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive',
        ];
    }
}
