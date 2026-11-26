<?php

namespace Tests\Feature;

use Database\Seeders\AdminSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    public function test_un_administrador_puede_iniciar_sesion(): void
    {
        $this->seed(AdminSeeder::class);

        $response = $this->post('/login', [
            'email' => 'admin@test.com',
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_credenciales_invalidas_son_rechazadas(): void
    {
        $this->seed(AdminSeeder::class);

        $response = $this->from('/login')->post('/login', [
            'email' => 'admin@test.com',
            'password' => 'incorrecta',
        ]);

        $this->assertGuest();
        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
    }

    public function test_un_usuario_autenticado_puede_cerrar_sesion(): void
    {
        $this->seed(AdminSeeder::class);

        $this->post('/login', [
            'email' => 'admin@test.com',
            'password' => 'password',
        ]);

        $this->post('/logout')->assertRedirect(route('login'));
        $this->assertGuest();
    }
}
