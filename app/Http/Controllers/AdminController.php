<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Product;
use App\Models\Testimonial;

class AdminController extends Controller
{
    // Auth Methods
    public function login()
    {
        return view('admin.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'Login gagal! Email atau password salah.');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        // Keep session alive for other guards (User)
        // $request->session()->invalidate();
        // $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }

    // Dashboard
    public function dashboard()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }
        
        $ongoingOrders = Order::whereIn('status', ['confirmed', 'delivering'])->with('items.product')->latest()->get();
        $pendingOrders = Order::where('status', 'pending')->with('items.product')->latest()->get();
        $allOrders = Order::latest()->get();
        $pendingTestimonials = Testimonial::where('is_approved', false)->get();
        $products = Product::all();

        // Chart Data (Last 7 Days)
        $revenueData = Order::where('status', 'completed')
            ->where('created_at', '>=', now()->subDays(6))
            ->selectRaw('DATE(created_at) as date, SUM(total_price) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $chartLabels = [];
        $chartValues = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $chartLabels[] = now()->subDays($i)->format('d M');
            $dayData = $revenueData->where('date', $date)->first();
            $chartValues[] = $dayData ? $dayData->total : 0;
        }
        
        return view('admin.dashboard', compact('pendingOrders', 'ongoingOrders', 'allOrders', 'pendingTestimonials', 'products', 'chartLabels', 'chartValues'));
    }

    // Orders & Reviews
    public function updateOrderStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $data = ['status' => $request->status];
        
        // Auto-mark as paid if completed (Assuming money received)
        if ($request->status == 'completed') {
            $data['payment_status'] = 'paid';
        }
        
        $order->update($data);
        return back()->with('success', 'Status pesanan diperbarui.');
    }
    
    public function approveTestimonial($id)
    {
        $test = Testimonial::findOrFail($id);
        $test->update(['is_approved' => true]);
        return back()->with('success', 'Testimoni disetujui.');
    }

    // Product CRUD
    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'description' => 'required',
            'category' => 'required',
            'stock' => 'required|integer',
            'image' => 'nullable|image|max:10240'
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = '/storage/' . $path;
        } else {
            $validated['image'] = 'https://via.placeholder.com/300x200.png?text=' . urlencode($validated['name']);
        }

        Product::create($validated);
        return back()->with('success', 'Produk berhasil ditambahkan.');
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|max:10240'
        ]);
        
        $data = $request->except(['image']);
        
        if($request->stock <= 0) {
            $data['is_ready'] = false;
        } else {
            $data['is_ready'] = true;
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image'] = '/storage/' . $path;
        }

        $product->update($data);
        return back()->with('success', 'Produk diperbarui.');
    }

    public function deleteProduct($id)
    {
        Product::findOrFail($id)->delete();
        return back()->with('success', 'Produk dihapus (Soft Delete).');
    }

    public function updateStock(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->stock = $request->stock;
        $product->is_ready = $request->stock > 0;
        $product->save();
        
        return back()->with('success', 'Stok produk berhasil diperbarui.');
    }

    public function getProductImage($filename)
    {
        $path = storage_path('app/public/products/' . $filename);

        if (!file_exists($path)) {
             // Fallback to check if it matches legacy seed data pattern (url) or just fail gracefully
             return redirect('https://via.placeholder.com/400x300.png?text=Image+Missing');
        }

        $file = file_get_contents($path);
        $type = mime_content_type($path);

        return response($file, 200)->header("Content-Type", $type);
    }
}
