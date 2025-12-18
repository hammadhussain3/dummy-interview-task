<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\DummyPaymentService;
use App\Events\OrderPlaced;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\Order;
use Illuminate\Support\Facades\DB;


/**
 * @OA\Post(
 *     path="/orders",
 *     tags={"Orders"},
 *     summary="Place a new order",
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="products",
 *                 type="array",
 *                 @OA\Items(
 *                     @OA\Property(property="product_id", type="integer"),
 *                     @OA\Property(property="quantity", type="integer")
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(response=201, description="Order created")
 * )
 *
 * @OA\Get(
 *     path="/orders",
 *     tags={"Orders"},
 *     summary="Get order history",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(response=200, description="Order list")
 * )
 */

class OrderController extends Controller
{
    public function store(Request $request, DummyPaymentService $paymentService)
{
    $request->validate([
        'products' => 'required|array'
    ]);

    return DB::transaction(function () use ($request, $paymentService) {

        $order = Order::create([
            'user_id' => auth()->id(),
            'total_amount' => 0,
            'payment_method' => 'dummy',
            'payment_status' => 'pending'
        ]);

        $total = 0;

        foreach ($request->products as $item) {

            $product = Product::findOrFail($item['product_id']);

            if ($product->quantity < $item['quantity']) {
                abort(400, 'Stock not enough');
            }

            $total += $product->price * $item['quantity'];

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'price' => $product->price,
                'quantity' => $item['quantity']
            ]);
        }

        // 🧠 PAYMENT PROCESS
        $payment = $paymentService->pay($total);

        if ($payment['status'] !== 'paid') {
            abort(402, 'Payment failed');
        }

        // Update stock AFTER payment success
        foreach ($request->products as $item) {
            Product::where('id', $item['product_id'])
                ->decrement('quantity', $item['quantity']);
        }

        $order->update([
    'total_amount' => $total,
    'payment_status' => 'paid',
    'transaction_id' => $payment['transaction_id'],
    'status' => 'confirmed'
]);

event(new OrderPlaced($order->load('items','user')));


        return $order->load('items');
    });
}


    public function index()
    {
        return Order::where('user_id',auth()->id())
            ->with('items')->get();
    }
}

