<?php

namespace Tests\Feature;

use App\Models\Producto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProductoTest extends TestCase
{
    use RefreshDatabase;

    private function actingAsAdmin()
    {
        $admin = User::factory()->create([
            'rol' => 'admin',
            'password' => Hash::make('password123'),
        ]);

        return $this->actingAs($admin, 'sanctum');
    }

    public function test_puede_listar_productos(): void
    {
        Producto::factory()->count(5)->create();

        $this->actingAsAdmin()
            ->getJson('/api/productos')
            ->assertOk()
            ->assertJsonCount(5, 'data');
    }

    public function test_puede_crear_producto(): void
    {
        $this->actingAsAdmin()
            ->postJson('/api/productos', [
                'nombre' => 'Laptop Dell',
                'descripcion' => 'Equipo para pruebas automatizadas',
                'precio' => 1299.99,
                'stock' => 10,
                'categoria_id' => null,
            ])
            ->assertCreated()
            ->assertJsonPath('data.nombre', 'Laptop Dell')
            ->assertJsonPath('data.stock', 10);

        $this->assertDatabaseHas('productos', [
            'nombre' => 'Laptop Dell',
        ]);
    }

    public function test_puede_actualizar_y_eliminar_producto_como_admin(): void
    {
        $producto = Producto::factory()->create([
            'nombre' => 'Teclado Basico',
            'precio' => 299.99,
            'stock' => 4,
        ]);

        $this->actingAsAdmin()
            ->putJson("/api/productos/{$producto->id}", [
                'nombre' => 'Teclado Pro',
                'descripcion' => 'Actualizado desde prueba automatizada',
                'precio' => 349.99,
                'stock' => 7,
                'categoria_id' => null,
            ])
            ->assertOk()
            ->assertJsonPath('data.nombre', 'Teclado Pro')
            ->assertJsonPath('data.stock', 7);

        $this->assertDatabaseHas('productos', [
            'id' => $producto->id,
            'nombre' => 'Teclado Pro',
        ]);

        $this->actingAsAdmin()
            ->deleteJson("/api/productos/{$producto->id}")
            ->assertNoContent();

        $this->assertDatabaseMissing('productos', [
            'id' => $producto->id,
        ]);
    }

    public function test_cliente_no_puede_eliminar(): void
    {
        $cliente = User::factory()->create([
            'rol' => 'cliente',
            'password' => Hash::make('password123'),
        ]);

        $producto = Producto::factory()->create();

        $this->actingAs($cliente, 'sanctum')
            ->deleteJson("/api/productos/{$producto->id}")
            ->assertForbidden();
    }

    public function test_validacion_falla_si_falta_el_nombre(): void
    {
        $this->actingAsAdmin()
            ->postJson('/api/productos', [
                'descripcion' => 'Sin nombre',
                'precio' => 150,
                'stock' => 3,
            ])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['nombre']);
    }
}
