<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PostmanUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'postman@example.com'],
            [
                'name' => 'Usuario Postman',
                'password' => Hash::make('Password123!'),
            ]
        );
    }
}
