<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Rezvan',
            'email' => 'rezvan@code.com',
            'password' => '123456789',
            'ip' => '172.24.0.1'
        ]);

        User::factory()->create([
            'name' => 'karl',
            'email' => 'rezvanamani@code.com',
            'password' => '123456789',
            'ip' => '172.24.0.1'
        ]);
        User::factory()->create([
            'name' => 'adj',
            'email' => 'rezvan1@code.com',
            'password' => '123456789',
            'ip' => '172.24.0.1'
        ]);
        User::factory()->create([
            'name' => 'melchy',
            'email' => 'rezvan2@code.com',
            'password' => '123456789',
            'ip' => '172.24.0.1'
        ]);
        User::factory()->create([
            'name' => 'lia',
            'email' => 'rezvan3@code.com',
            'password' => '123456789',
            'ip' => '172.24.0.1'
        ]);
        User::factory()->create([
            'name' => 'moo',
            'email' => 'rezvan4@code.com',
            'password' => '123456789',
            'ip' => '172.24.0.1'
        ]);
        User::factory()->create([
            'name' => 'raha',
            'email' => 'rezvan5@code.com',
            'password' => '123456789',
            'ip' => '172.24.0.1'
        ]);
        User::factory()->create([
            'name' => 'saro',
            'email' => 'rezvan6@code.com',
            'password' => '123456789',
            'ip' => '172.24.0.1'
        ]);
    }
}
