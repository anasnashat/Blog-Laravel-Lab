<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::firstOrCreate([
            'email' => 'test@test',
        ], [
            'name' => 'Admin User',
            'password' => Hash::make('123456789'),
        ]);
        $this->call([
            PostSeeder::class,
        ]);
    }
}
