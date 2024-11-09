<?php

namespace Tests\Feature;

use App\Models\TravelOrder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tests\TestCase;

class TravelOrderTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected $token;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'email' => fake()->unique()->safeEmail(),
            'password' => 'password'
        ]);

        $this->token = JWTAuth::fromUser($this->user);
    }

    public function test_login()
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

    public function test_logout()
    {
        $response = $this->postJson(route('logout'), [], [
            'Authorization' => 'Bearer ' . $this->token,
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message'
            ]);
    }

    public function test_list_travel_orders()
    {
        $response = $this->getJson(route('orders.index'), [
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(200);
    }

    public function filter_travel_orders_by_status()
    {
        $response = $this->getJson(route('orders.index', ['status' => 'aprovado']), [
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(200);
    }

    public function test_create_travel_order()
    {
        $response = $this->postJson(route('orders.store'), [
            'solicitante' => fake()->name(),
            'destino' => fake()->city(),
            'data_ida' => fake()->dateTimeBetween('now', '+1 year')->format('Y-m-d'),
            'data_volta' => fake()->dateTimeBetween('+1 year', '+2 years')->format('Y-m-d'),
        ], [
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'message',
                'travel_order' => [
                    'id',
                    'solicitante',
                    'destino',
                    'data_ida',
                    'data_volta',
                    'created_at',
                    'updated_at'
                ]
            ]);
    }

    public function test_show_travel_order()
    {
        $travel_order = TravelOrder::factory()->create();

        $response = $this->getJson(route('orders.show', ['order' => $travel_order->id]), [
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'travel_order' => [
                    'id',
                    'solicitante',
                    'destino',
                    'data_ida',
                    'data_volta',
                    'status',
                    'created_at',
                    'updated_at'
                ]
            ]);
    }

    public function test_update_travel_order_status()
    {
        $travel_order = TravelOrder::factory()->create();

        $response = $this->putJson(route('orders.update', ['order' => $travel_order->id]), [
            'status' => 'aprovado'
        ], [
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'travel_order' => [
                    'id',
                    'solicitante',
                    'destino',
                    'data_ida',
                    'data_volta',
                    'status',
                    'created_at',
                    'updated_at'
                ]
            ]);
    }
}
