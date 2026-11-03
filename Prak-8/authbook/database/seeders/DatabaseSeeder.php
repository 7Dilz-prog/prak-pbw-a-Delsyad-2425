<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; 

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        User::firstOrCreate(
            ['email' => 'staff@example.com'],
            [
                'name' => 'Staff User',
                'password' => Hash::make('password'),
                'role' => 'staff',
            ]
        );

        User::firstOrCreate(
            ['email' => 'viewer@example.com'],
            [
                'name' => 'Viewer User',
                'password' => Hash::make('password'),
                'role' => 'viewer',
            ]
        );

        // Bagian di bawah ini tetap dibiarkan:
        // Buat 10 authors
        $authors = Author::factory(10)->create();

        // Buat 50 books dengan random authors
        Book::factory(50)->create([
            'author_id' => fn() => $authors->random()->id,
        ]);
    }
}