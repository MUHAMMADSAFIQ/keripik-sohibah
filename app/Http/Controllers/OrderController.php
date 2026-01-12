<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $products = Product::where('is_ready', true)->get();
        return view('order.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'items' => 'required|array',
            'items.*.id' => 'exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            // 'distance_meters' => 'required|numeric|min:0', // Removed
            'shipping_cost' => 'required|numeric|min:0', 
            'latitude' => 'nullable|string',
            'longitude' => 'nullable|string',
        ]);

        // Shipping Cost is now from RajaOngkir (Frontend)
        $shippingCost = $validated['shipping_cost'];
        // $paymentMethod = $request->payment_method; // Removed: Selected in next step

        DB::beginTransaction();

        try {
            $totalProductPrice = 0;
            $itemsData = [];

            foreach ($validated['items'] as $item) {
                $product = Product::find($item['id']);
                $subtotal = $product->price * $item['quantity'];
                $totalProductPrice += $subtotal;
                
                $itemsData[] = [
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price
                ];
            }

            $order = Order::create([
                'customer_name' => $validated['customer_name'],
                'address' => $validated['address'],
                'phone' => $validated['phone'],
                'delivery_method' => $request->delivery_method ?? 'delivery',
                'distance_meters' => 0, 
                'shipping_cost' => $shippingCost,
                'total_price' => $totalProductPrice + $shippingCost,
                'status' => 'pending',
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'payment_status' => 'pending', 
                'payment_method' => 'pending', // Placeholder until selected
            ]);

            foreach ($itemsData as $data) {
                $order->items()->create($data);
            }

            DB::commit();

            // Redirect to Payment Method Selection Page
            return redirect()->route('payment.select', $order->id)->with('success', 'Pesanan berhasil dibuat! Silakan pilih metode pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function status($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        return view('order.status', compact('order'));
    }

    // New Tracking Methods
    public function track()
    {
        return view('order.track');
    }

    public function check(Request $request)
    {
        $request->validate(['phone' => 'required']);
        $orders = Order::where('phone', 'like', '%' . $request->phone . '%')->latest()->get();
        return view('order.track', compact('orders'));
    }
}
