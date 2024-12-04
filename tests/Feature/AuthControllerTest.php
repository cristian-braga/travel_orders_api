<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_and_receive_token()
    {
        $response = $this->postJson(route('login'), [
            'email' => $this->user->email,
            'password' => 'password'
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'access_token',
                'token_type',
                'expires_in'
            ]);
    }

    public function test_login_returns_unauthorized_with_invalid_credentials()
    {
        $response = $this->postJson(route('login'), [
            'email' => 'wrong@email.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'error' => 'Credenciais inválidas!'
            ]);
    }

    public function test_user_can_logout_successfully()
    {
        $response = $this->postJson(route('logout'), [], [
            'Authorization' => "Bearer {$this->token}"
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Deslogado com sucesso!'
            ]);
    }
}
