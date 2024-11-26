<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{

    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }


    /** @test */
    public function it_visit_page_of_login()
    {
        $this->get('/login')
            ->assertStatus(200)
            ->assertSee('login');
    }

    /** @test */
    public function it_can_login_successfully()
    {
        // Crear un usuario de prueba
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password123')
        ]);

        // Hacer una petición POST a la ruta de login con las credenciales correctas
        $response = $this->postJson('/api/login', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        // Asegurarse de que la respuesta tiene un estado 200
        $response->assertStatus(200);

        // Asegurarse de que la respuesta contiene el usuario y el token
        $response->assertJsonStructure([
            'user',
            'token'
        ]);
    }

}
