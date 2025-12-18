<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends ApiTestCase
{
    use RefreshDatabase;

    public function test_customer_can_view_active_products()
    {
        Product::factory()->create(['status' => true]);
        Product::factory()->create(['status' => false]);

        $this->actingAsUser();

        $response = $this->getJson('/api/products');

        $response->assertStatus(200)
                 ->assertJsonCount(1);
    }
}
