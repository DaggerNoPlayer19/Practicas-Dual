<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_usuario_puede_registrarse(): void
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Juan Lopez',
            'email' => 'juan@test.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertCreated()
            ->assertJsonStructure(['token', 'user' => ['id', 'name', 'email', 'rol', 'permisos']])
            ->assertJsonPath('user.email', 'juan@test.com')
            ->assertJsonPath('user.rol', 'cliente');

        $this->assertDatabaseHas('users', [
            'email' => 'juan@test.com',
            'rol' => 'cliente',
        ]);
    }

    public function test_login_con_credenciales_incorrectas(): void
    {
        User::factory()->create([
            'email' => 'admin@test.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'noexiste@test.com',
            'password' => 'wrongpass',
        ]);

        $response->assertStatus(401)
            ->assertJsonPath('message', 'Credenciales incorrectas');
    }

    public function test_usuario_autenticado_puede_ver_su_perfil_y_cerrar_sesion(): void
    {
        $user = User::factory()->create([
            'rol' => 'editor',
        ]);

        $token = $user->createToken('auth-token')->plainTextToken;

        $this->withHeader('Authorization', "Bearer {$token}")
            ->getJson('/api/me')
            ->assertOk()
            ->assertJsonPath('email', $user->email)
            ->assertJsonPath('rol', 'editor')
            ->assertJsonPath('permisos.crear', true)
            ->assertJsonPath('permisos.editar', true);

        $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/logout')
            ->assertOk()
            ->assertJsonPath('message', 'Sesion cerrada correctamente');
    }
}
