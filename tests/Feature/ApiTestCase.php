<?php

namespace Tests\Feature;

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ApiTestCase extends TestCase
{
    protected function actingAsUser(string $role = 'customer'): User
    {
        $user = User::factory()->create([
            'role' => $role
        ]);

        Sanctum::actingAs($user);

        return $user;
    }
}
