<?php

namespace Tests;

use App\Models\TravelOrder;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

abstract class TestCase extends BaseTestCase
{
    protected $user, $token, $travel_order;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'email' => fake()->unique()->safeEmail(),
            'password' => 'password'
        ]);

        $this->token = JWTAuth::fromUser($this->user);

        $this->travel_order = TravelOrder::factory()->create();
    }
}
