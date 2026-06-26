<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class Practice4MiddlewareTest extends TestCase
{
    use RefreshDatabase;

    private function createUserWithRole(string $roleName): User
    {
        $role = Role::firstOrCreate(['name' => $roleName]);

        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $user->roles()->attach($role);
        $user->refresh();

        return $user;
    }

    public function test_admin_panel_is_available_for_admin_users(): void
    {
        $user = $this->createUserWithRole('admin');

        $this->actingAs($user)
            ->get('/admin/panel')
            ->assertOk()
            ->assertSee('Acceso concedido al rol administrador');
    }

    public function test_editor_page_is_available_for_editor_users(): void
    {
        $user = $this->createUserWithRole('editor');

        $this->actingAs($user)
            ->get('/editor/articulos')
            ->assertOk()
            ->assertSee('Acceso concedido al rol editor');
    }

    public function test_solo_celular_redirects_mobile_user_agents(): void
    {
        $this->get('/celular/noticias', [
            'User-Agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.0 Mobile/15E148 Safari/604.1',
        ])
            ->assertRedirect('/movil');
    }

    public function test_celular_route_is_available_for_desktop_users(): void
    {
        $this->get('/celular/galeria')
            ->assertOk();
    }
}
