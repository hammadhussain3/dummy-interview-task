<?php

namespace Tests\Feature;

use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderHistoryTest extends ApiTestCase
{
    use RefreshDatabase;

    public function test_customer_can_view_order_history()
    {
        $user = $this->actingAsUser();

        Order::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this->getJson('/api/orders');

        $response->assertStatus(200)
                 ->assertJsonCount(1);
    }
}
