<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreTravelOrderRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_travel_order_requires_all_fields()
    {
        $response = $this->postJson(route('orders.store'), [
            'solicitante' => '',
            'destino' => '',
            'data_ida' => '',
            'data_volta' => ''
        ], [
            'Authorization' => "Bearer {$this->token}"
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['solicitante', 'destino', 'data_ida', 'data_volta']);
    }

    public function test_travel_order_requires_solicitante_field()
    {
        $response = $this->postJson(route('orders.store'), [
            'solicitante' => '',
            'destino' => fake()->city(),
            'data_ida' => now()->addDays(1)->toDateString(),
            'data_volta' => now()->addDays(2)->toDateString()
        ], [
            'Authorization' => "Bearer {$this->token}"
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('solicitante');
    }

    public function test_travel_order_requires_destino_field()
    {
        $response = $this->postJson(route('orders.store'), [
            'solicitante' => fake()->name(),
            'destino' => '',
            'data_ida' => now()->addDays(1)->toDateString(),
            'data_volta' => now()->addDays(2)->toDateString()
        ], [
            'Authorization' => "Bearer {$this->token}"
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('destino');
    }

    public function test_travel_order_requires_valid_data_ida_and_data_volta()
    {
        $response = $this->postJson(route('orders.store'), [
            'solicitante' => fake()->name(),
            'destino' => fake()->city(),
            'data_ida' => now()->subDays(1)->toDateString(),
            'data_volta' => now()->subDays(1)->toDateString()
        ], [
            'Authorization' => "Bearer {$this->token}"
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['data_ida', 'data_volta']);
    }
}
