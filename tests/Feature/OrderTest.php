<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends ApiTestCase
{
    use RefreshDatabase;

    public function test_customer_can_place_order()
    {
        $this->actingAsUser();

        $product = Product::factory()->create([
            'price' => 100,
            'quantity' => 10
        ]);

        $response = $this->postJson('/api/orders', [
            'products' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 2
                ]
            ]
        ]);

        $response->assertStatus(201)
                 ->assertJsonPath('payment_status', 'paid');

        $this->assertDatabaseHas('orders', [
            'total_amount' => 200
        ]);

        $this->assertDatabaseHas('order_items', [
            'product_id' => $product->id,
            'quantity' => 2
        ]);
    }
}
