<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $usuarios = [
            [
                'email' => 'admin@tienda.com',
                'name' => 'Administrador',
                'password' => 'Admin1234',
                'rol' => 'admin',
            ],
            [
                'email' => 'editor@tienda.com',
                'name' => 'Editor',
                'password' => 'Editor1234',
                'rol' => 'editor',
            ],
            [
                'email' => 'cliente@tienda.com',
                'name' => 'Cliente Demo',
                'password' => 'Cliente1234',
                'rol' => 'cliente',
            ],
        ];

        foreach ($usuarios as $usuario) {
            User::updateOrCreate(
                ['email' => $usuario['email']],
                [
                    'name' => $usuario['name'],
                    'password' => Hash::make($usuario['password']),
                    'rol' => $usuario['rol'],
                ],
            );
        }
    }
}
