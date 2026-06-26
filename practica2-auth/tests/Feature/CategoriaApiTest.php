<?php

namespace Tests\Feature;

use App\Models\Categoria;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class CategoriaApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_lista_categorias_en_json(): void
    {
        Categoria::create([
            'nombre' => 'Tecnología',
            'slug' => Str::slug('Tecnología'),
        ]);

        $response = $this->getJson('/api/categorias');

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'nombre', 'slug', 'created_at', 'updated_at'],
                ],
            ]);
    }

    public function test_crea_una_categoria_con_status_201(): void
    {
        $response = $this->postJson('/api/categorias', [
            'nombre' => 'Papelería',
        ]);

        $response->assertCreated()
            ->assertJsonPath('data.nombre', 'Papelería')
            ->assertJsonPath('data.slug', 'papeleria');

        $this->assertDatabaseHas('categorias', [
            'nombre' => 'Papelería',
            'slug' => 'papeleria',
        ]);
    }

    public function test_muestra_una_categoria(): void
    {
        $categoria = Categoria::create([
            'nombre' => 'Hogar',
            'slug' => 'hogar',
        ]);

        $response = $this->getJson("/api/categorias/{$categoria->id}");

        $response->assertOk()
            ->assertJsonPath('data.id', $categoria->id)
            ->assertJsonPath('data.nombre', 'Hogar');
    }

    public function test_actualiza_una_categoria(): void
    {
        $categoria = Categoria::create([
            'nombre' => 'Deporte',
            'slug' => 'deporte',
        ]);

        $response = $this->putJson("/api/categorias/{$categoria->id}", [
            'nombre' => 'Deportes',
        ]);

        $response->assertOk()
            ->assertJsonPath('data.nombre', 'Deportes')
            ->assertJsonPath('data.slug', 'deportes');

        $this->assertDatabaseHas('categorias', [
            'id' => $categoria->id,
            'nombre' => 'Deportes',
            'slug' => 'deportes',
        ]);
    }

    public function test_elimina_una_categoria_con_status_200(): void
    {
        $categoria = Categoria::create([
            'nombre' => 'Salud',
            'slug' => 'salud',
        ]);

        $response = $this->deleteJson("/api/categorias/{$categoria->id}");

        $response->assertOk()
            ->assertJsonPath('message', 'Categoria eliminada correctamente');

        $this->assertDatabaseMissing('categorias', [
            'id' => $categoria->id,
        ]);
    }
}
