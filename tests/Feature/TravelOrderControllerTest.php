<?php

namespace Tests\Feature;

use App\Models\TravelOrder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TravelOrderControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_travel_order()
    {
        $response = $this->postJson(route('orders.store'), [
            'solicitante' => fake()->name(),
            'destino' => fake()->city(),
            'data_ida' => now()->addDays(1)->toDateString(),
            'data_volta' => now()->addDays(2)->toDateString()
        ], [
            'Authorization' => "Bearer {$this->token}"
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'solicitante',
                    'destino',
                    'data_ida',
                    'data_volta',
                    'created_at',
                    'updated_at'
                ],
                'message'
            ]);
    }

    public function test_user_can_update_travel_order()
    {
        $response = $this->putJson(route('orders.update', ['order' => $this->travel_order->id]), [
            'status' => 'aprovado'
        ], [
            'Authorization' => "Bearer {$this->token}"
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'solicitante',
                    'destino',
                    'data_ida',
                    'data_volta',
                    'created_at',
                    'updated_at'
                ],
                'message'
            ]);
    }

    public function test_user_can_get_travel_order()
    {
        $response = $this->getJson(route('orders.show', ['order' => $this->travel_order->id]), [
            'Authorization' => "Bearer {$this->token}"
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
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

    public function test_user_can_get_all_travel_orders()
    {
        TravelOrder::factory(3)->create();

        $response = $this->getJson(route('orders.index'), [
            'Authorization' => "Bearer {$this->token}"
        ]);

        $response->assertStatus(200)
            ->assertJsonCount(4, 'data');  // 3 registros criados + o registro dentro da classe
    }

    public function test_user_can_get_all_travel_orders_filtered_by_status()
    {
        $response = $this->getJson(route('orders.index', ['status' => 'aprovado']), [
            'Authorization' => "Bearer {$this->token}"
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['data']);
    }
}
