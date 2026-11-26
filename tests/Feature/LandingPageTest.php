<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LandingPageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Las vistas usan @vite; en pruebas no hace falta compilar assets.
        $this->withoutVite();
    }

    public function test_la_pagina_de_inicio_carga_correctamente(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Evaluados');
    }

    public function test_el_login_es_accesible_sin_autenticacion(): void
    {
        $this->get('/login')->assertOk();
    }
}
