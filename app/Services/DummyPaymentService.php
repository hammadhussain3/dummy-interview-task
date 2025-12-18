<?php

namespace App\Services;

use Illuminate\Support\Str;

class DummyPaymentService
{
    public function pay(float $amount): array
    {
        $success = rand(1,10) <= 9;

        if (!$success) {
            return [
                'status' => 'failed',
                'transaction_id' => null
            ];
        }

        return [
            'status' => 'paid',
            'transaction_id' => 'DUMMY-' . Str::upper(Str::random(10))
        ];
    }
}
