<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Set Midtrans configuration
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    /**
     * Show Payment Method Selection Page
     */ 
    public function selectPaymentMethod(Order $order)
    {
        if ($order->payment_status === 'paid' && $order->payment_method !== 'cod') {
             return redirect()->route('payment.success', $order->id);
        }
        return view('payment.select', compact('order'));
    }

    /**
     * Process Selected Payment Method
     */
    public function processPaymentMethod(Request $request, Order $order)
    {
        $request->validate([
            'payment_method' => 'required|in:midtrans,cod'
        ]);
        
        $order->update([
            'payment_method' => $request->payment_method
        ]);
        
        if($request->payment_method === 'cod') {
            return redirect()->route('payment.success', $order->id)
                ->with('success', 'Pesanan COD berhasil dikonfirmasi! Mohon siapkan uang tunai.');
        } else {
            return redirect()->route('payment.show', $order->id);
        }
    }

    /**
     * Create payment token for an order
     */
    public function createPayment(Order $order)
    {
        try {
            // Prepare transaction details
            $params = [
                'transaction_details' => [
                    'order_id' => 'ORDER-' . $order->id . '-' . time(),
                    'gross_amount' => (int) $order->total_price,
                ],
                'customer_details' => [
                    'first_name' => $order->customer_name,
                    'email' => $order->email ?? 'customer@keripiksohibah.com',
                    'phone' => $order->phone,
                ],
                'item_details' => [
                    [
                        'id' => 'ORDER-' . $order->id,
                        'price' => (int) $order->total_price,
                        'quantity' => 1,
                        'name' => 'Pesanan Keripik Sohibah #' . $order->id,
                    ]
                ],
                'enabled_payments' => [
                    'gopay', 'shopeepay', 'other_qris', // E-Wallets
                    'bca_va', 'bni_va', 'bri_va', 'permata_va', 'other_va', // Bank Transfer
                    'credit_card', // Credit Card
                ],
            ];

            // Get Snap Token
            $snapToken = Snap::getSnapToken($params);

            // Save snap token to order
            $order->update([
                'snap_token' => $snapToken,
                'transaction_id' => $params['transaction_details']['order_id'],
            ]);

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'order_id' => $order->id,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create payment: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Handle Midtrans notification webhook
     */
    public function handleNotification(Request $request)
    {
        try {
            $notification = new Notification();

            $transactionStatus = $notification->transaction_status;
            $fraudStatus = $notification->fraud_status;
            $orderId = $notification->order_id;

            // Extract actual order ID from transaction ID
            preg_match('/ORDER-(\d+)-/', $orderId, $matches);
            $actualOrderId = $matches[1] ?? null;

            if (!$actualOrderId) {
                return response()->json(['message' => 'Invalid order ID'], 400);
            }

            $order = Order::find($actualOrderId);

            if (!$order) {
                return response()->json(['message' => 'Order not found'], 404);
            }

            // Update order based on transaction status
            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'accept') {
                    $order->update([
                        'payment_status' => 'paid',
                        'payment_method' => $notification->payment_type,
                        'paid_at' => now(),
                    ]);
                }
            } elseif ($transactionStatus == 'settlement') {
                $order->update([
                    'payment_status' => 'paid',
                    'payment_method' => $notification->payment_type,
                    'paid_at' => now(),
                ]);
            } elseif ($transactionStatus == 'pending') {
                $order->update([
                    'payment_status' => 'pending',
                    'payment_method' => $notification->payment_type,
                ]);
            } elseif ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel') {
                $order->update([
                    'payment_status' => $transactionStatus == 'expire' ? 'expired' : 'failed',
                ]);
            }

            return response()->json(['message' => 'Notification handled successfully']);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Show payment page
     */
    public function showPaymentPage(Order $order)
    {
        // If order already paid, redirect to success
        if ($order->payment_status === 'paid') {
            return redirect()->route('payment.success', $order->id);
        }

        // If no snap token, create one
        if (!$order->snap_token) {
            try {
                // Prepare transaction details
                $params = [
                    'transaction_details' => [
                        'order_id' => 'ORDER-' . $order->id . '-' . time(),
                        'gross_amount' => (int) $order->total_price,
                    ],
                    'customer_details' => [
                        'first_name' => $order->customer_name,
                        'email' => $order->email ?? 'customer@keripiksohibah.com',
                        'phone' => $order->phone,
                    ],
                    'item_details' => [
                        [
                            'id' => 'ORDER-' . $order->id,
                            'price' => (int) $order->total_price,
                            'quantity' => 1,
                            'name' => 'Pesanan Keripik Sohibah #' . $order->id,
                        ]
                    ],
                    'enabled_payments' => [
                        'gopay', 'shopeepay', 'other_qris', // E-Wallets
                        'bca_va', 'bni_va', 'bri_va', 'permata_va', 'other_va', // Bank Transfer
                        'credit_card', // Credit Card
                    ],
                ];

                // Get Snap Token
                $snapToken = Snap::getSnapToken($params);

                // Save snap token to order
                $order->update([
                    'snap_token' => $snapToken,
                    'transaction_id' => $params['transaction_details']['order_id'],
                ]);
                
                $order->refresh();
                
            } catch (\Exception $e) {
                // Check if it's a configuration error
                $errorMessage = $e->getMessage();
                if (strpos($errorMessage, 'ServerKey') !== false || strpos($errorMessage, 'server_key') !== false) {
                    return back()->with('error', '⚠️ Midtrans belum dikonfigurasi! Silakan setup API Keys di file .env terlebih dahulu. Lihat PAYMENT_SETUP.md untuk panduan lengkap.');
                }
                return back()->with('error', 'Gagal membuat token pembayaran: ' . $e->getMessage());
            }
        }

        return view('payment.checkout', [
            'order' => $order,
            'snapToken' => $order->snap_token,
            'clientKey' => config('midtrans.client_key'),
        ]);
    }

    /**
     * Payment success page
     */
    public function success(Order $order)
    {
        return view('payment.success', compact('order'));
    }

    /**
     * Payment failed page
     */
    public function failed(Order $order)
    {
        return view('payment.failed', compact('order'));
    }
}
