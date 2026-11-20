<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed the default authenticated user record.
     */
    public function run(): void
    {
        User::query()->delete();

        User::create([
            'username' => 'johnjames',
            'full_name' => 'John James',
            'email' => 'jpenarroyo53@gmail.com',
            'password' => Hash::make('password'),
        ]);
    }
}
