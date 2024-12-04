<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateTravelOrderRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_travel_order_requires_valid_status()
    {
        $response = $this->putJson(route('orders.update', ['order' => $this->travel_order->id]), [
            'status' => 'invalido'
        ], [
            'Authorization' => "Bearer {$this->token}"
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['status']);
    }
}
