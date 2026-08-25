<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeminiService
{
    public function generate(string $prompt)
    {
        $response = Http::post(
            config('services.gemini.url'),
            [
                'contents' => [
                    [
                        'parts' => [
                            [
                                'text' => $prompt
                            ]
                        ]
                    ]
                ]
            ]
        );

        if ($response->failed()) {
            throw new \Exception(
                'Gemini API request failed: ' . $response->body()
            );
        }

        return $response->json(
            'candidates.0.content.parts.0.text'
        );
    }
}