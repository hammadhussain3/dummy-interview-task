<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminProductTest extends ApiTestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_product()
    {
        $this->actingAsUser('admin');

        $response = $this->postJson('/api/admin/products', [
            'name' => 'Test Product',
            'price' => 150,
            'quantity' => 5
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('products', [
            'name' => 'Test Product'
        ]);
    }
}
