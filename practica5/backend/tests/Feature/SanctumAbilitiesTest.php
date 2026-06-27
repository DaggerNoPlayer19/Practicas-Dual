<?php

namespace Tests\Feature;

use App\Models\Producto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class SanctumAbilitiesTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_issues_expected_abilities_for_each_token_type(): void
    {
        $user = User::create([
            'name' => 'Demo Admin',
            'email' => 'admin@tienda.com',
            'password' => Hash::make('Admin1234'),
            'is_admin' => true,
        ]);

        $readResponse = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'Admin1234',
            'token_type' => 'read',
        ]);

        $readResponse->assertOk()
            ->assertJsonPath('abilities', ['ver'])
            ->assertJsonStructure(['token', 'user', 'abilities']);

        $writeResponse = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'Admin1234',
            'token_type' => 'write',
        ]);

        $writeResponse->assertOk()
            ->assertJsonPath('abilities', ['ver', 'crear', 'editar', 'eliminar']);
    }

    public function test_read_only_token_cannot_create_products(): void
    {
        $user = User::create([
            'name' => 'Demo Admin',
            'email' => 'admin@tienda.com',
            'password' => Hash::make('Admin1234'),
            'is_admin' => true,
        ]);

        Sanctum::actingAs($user, ['ver']);

        $this->postJson('/api/productos', [
            'nombre' => 'Producto restringido',
            'descripcion' => 'No debe poder crearse',
            'precio' => 99.90,
            'stock' => 4,
        ])
            ->assertForbidden()
            ->assertJsonPath('message', "Tu token no tiene el permiso 'crear' para esta accion.");
    }

    public function test_write_token_can_create_update_and_delete_products(): void
    {
        $user = User::create([
            'name' => 'Demo Admin',
            'email' => 'admin@tienda.com',
            'password' => Hash::make('Admin1234'),
            'is_admin' => true,
        ]);

        Sanctum::actingAs($user, ['ver', 'crear', 'editar', 'eliminar']);

        $storeResponse = $this->postJson('/api/productos', [
            'nombre' => 'Producto de prueba',
            'descripcion' => 'Creado por token con abilities',
            'precio' => 199.50,
            'stock' => 8,
        ]);

        $storeResponse->assertCreated()
            ->assertJsonPath('data.nombre', 'Producto de prueba');

        $productoId = $storeResponse->json('data.id');

        $this->putJson("/api/productos/{$productoId}", [
            'nombre' => 'Producto editado',
            'descripcion' => 'Actualizado',
            'precio' => 210.00,
            'stock' => 10,
        ])
            ->assertOk()
            ->assertJsonPath('data.nombre', 'Producto editado');

        $this->deleteJson("/api/productos/{$productoId}")
            ->assertNoContent();
    }
}