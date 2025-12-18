<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order Confirmed</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f6f8; font-family:Arial, Helvetica, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="padding:20px;">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.08);">

                <!-- Header -->
                <tr>
                    <td style="background:#2563eb; color:#ffffff; padding:20px; text-align:center;">
                        <h2 style="margin:0;">Order Confirmed 🎉</h2>
                    </td>
                </tr>

                <!-- Body -->
                <tr>
                    <td style="padding:24px; color:#333;">
                        <p style="margin-top:0;">Hi <strong>{{ $order->user->name }}</strong>,</p>

                        <p>
                            Your order <strong>#{{ $order->id }}</strong> has been
                            <span style="color:#16a34a; font-weight:bold;">successfully placed</span>.
                        </p>

                        <p style="background:#f1f5f9; padding:12px; border-radius:6px;">
                            <strong>Total Amount:</strong>
                            <span style="color:#2563eb;">${{ $order->total_amount }}</span>
                        </p>

                        <h4 style="margin-bottom:8px;">Order Items</h4>

                        <table width="100%" cellpadding="8" cellspacing="0" style="border-collapse:collapse;">
                            <thead>
                                <tr style="background:#f8fafc;">
                                    <th align="left" style="border-bottom:1px solid #e5e7eb;">Product ID</th>
                                    <th align="center" style="border-bottom:1px solid #e5e7eb;">Quantity</th>
                                    <th align="right" style="border-bottom:1px solid #e5e7eb;">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td style="border-bottom:1px solid #e5e7eb;">{{ $item->product_id }}</td>
                                    <td align="center" style="border-bottom:1px solid #e5e7eb;">{{ $item->quantity }}</td>
                                    <td align="right" style="border-bottom:1px solid #e5e7eb;">${{ $item->price }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <p style="margin-top:20px;">
                            Thank you for shopping with us ❤️  
                            <br>
                            <strong>We hope to see you again!</strong>
                        </p>
                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td style="background:#f8fafc; padding:16px; text-align:center; font-size:12px; color:#6b7280;">
                        © {{ date('Y') }} Mini E-Commerce. All rights reserved.
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>

</body>
</html>
