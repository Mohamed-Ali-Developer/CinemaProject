<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Cinemas (10 rows)[cite: 1]
        for ($i = 1; $i <= 10; $i++) {
            DB::table('cinemas')->insert([
                'name'       => "Cinema $i",
                'email'      => "cinema$i@example.com",
                'phone'      => "0100000000$i",
                'address'    => "Address Street $i, City",
                'status'     => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 2. Genres (10 rows)[cite: 2]
        $genres = ['Action', 'Comedy', 'Drama', 'Horror', 'Sci-Fi', 'Romance', 'Thriller', 'Animation', 'Adventure', 'Fantasy'];
        foreach ($genres as $index => $genre) {
            DB::table('genres')->insert([
                'name'        => $genre,
                'description' => "Description for $genre genre.",
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }
}
