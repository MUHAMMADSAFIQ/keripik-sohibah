<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PaymentController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/menu', [HomeController::class, 'menu'])->name('menu');
Route::get('/kontak', [HomeController::class, 'contact'])->name('contact');
Route::post('/kontak', [HomeController::class, 'storeMessage'])->name('contact.store');
Route::post('/api/chat', [HomeController::class, 'geminiChat'])->name('chat');
Route::get('/mitra', [HomeController::class, 'mitra'])->name('mitra');

Route::get('/testimoni', [TestimonialController::class, 'index'])->name('testimonials');
Route::post('/testimoni', [TestimonialController::class, 'store'])->name('testimonials.store');

Route::get('/pesan', [OrderController::class, 'index'])->name('order.create');
Route::post('/pesan', [OrderController::class, 'store'])->name('order.store');
Route::get('/pesan/status/{id}', [OrderController::class, 'status'])->name('order.status');
Route::get('/cek-pesanan', [OrderController::class, 'track'])->name('order.track');
Route::get('/cek-pesanan/cari', [OrderController::class, 'check'])->name('order.check');

// Payment Routes
Route::get('/payment/{order}/select', [PaymentController::class, 'selectPaymentMethod'])->name('payment.select');
Route::post('/payment/{order}/process', [PaymentController::class, 'processPaymentMethod'])->name('payment.process');
Route::get('/payment/{order}', [PaymentController::class, 'showPaymentPage'])->name('payment.show');
Route::post('/payment/{order}/create', [PaymentController::class, 'createPayment'])->name('payment.create');
Route::post('/payment/notification', [PaymentController::class, 'handleNotification'])->name('payment.notification');
Route::get('/payment/{order}/success', [PaymentController::class, 'success'])->name('payment.success');
Route::get('/payment/{order}/failed', [PaymentController::class, 'failed'])->name('payment.failed');

// Image Route (Direct Serve)
Route::get('/product-img/{filename}', [AdminController::class, 'getProductImage'])->name('product.image');

// User Auth Routes
use App\Http\Controllers\UserAuthController;
Route::get('/login', [UserAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserAuthController::class, 'login'])->name('login.perform');
Route::get('/register', [UserAuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [UserAuthController::class, 'register'])->name('register.perform');
Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout');
Route::get('/auth/google', [UserAuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [UserAuthController::class, 'handleGoogleCallback']);

// User Profile Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});

// Admin Auth Routes
Route::get('/admin/login', [AdminController::class, 'login'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'authenticate'])->name('admin.login.perform');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

// Protected Admin Routes
Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/admin/order/{id}', [AdminController::class, 'updateOrderStatus'])->name('admin.order.update');
    Route::post('/admin/testimonial/{id}/approve', [AdminController::class, 'approveTestimonial'])->name('admin.testimonial.approve');
    
    // Product Management
    Route::post('/admin/product/store', [AdminController::class, 'storeProduct'])->name('admin.product.store');
    Route::post('/admin/product/{id}/update', [AdminController::class, 'updateProduct'])->name('admin.product.update');
    Route::post('/admin/product/{id}/delete', [AdminController::class, 'deleteProduct'])->name('admin.product.delete');
    Route::post('/admin/product/{id}/stock', [AdminController::class, 'updateStock'])->name('admin.product.stock');
    
    // Chat Management
    Route::get('/admin/chat', [App\Http\Controllers\AdminChatController::class, 'index'])->name('admin.chat.index');
    Route::get('/admin/chat/{sessionId}', [App\Http\Controllers\AdminChatController::class, 'show'])->name('admin.chat.show');
    Route::post('/admin/chat/{sessionId}/send', [App\Http\Controllers\AdminChatController::class, 'sendMessage'])->name('admin.chat.send');
    Route::get('/admin/chat/{sessionId}/messages/{lastId}', [App\Http\Controllers\AdminChatController::class, 'getNewMessages'])->name('admin.chat.messages');
    Route::post('/admin/chat/online-status', [App\Http\Controllers\AdminChatController::class, 'setOnlineStatus'])->name('admin.chat.online');
});

// Public API for checking admin status
Route::get('/api/admin/online', [App\Http\Controllers\AdminChatController::class, 'checkAdminOnline'])->name('api.admin.online');

// API for admin chat widget
Route::get('/api/admin/unread-count', function() {
    $count = \App\Models\ChatMessage::where('sender_type', 'user')->where('is_read', false)->count();
    return response()->json(['count' => $count]);
});

Route::get('/api/admin/chat-sessions', function() {
    $sessions = \App\Models\ChatMessage::select('session_id', 'user_name', 'user_phone')
        ->selectRaw('MAX(created_at) as last_message_at')
        ->selectRaw('SUM(CASE WHEN is_read = 0 AND sender_type = "user" THEN 1 ELSE 0 END) as unread_count')
        ->groupBy('session_id', 'user_name', 'user_phone')
        ->orderBy('last_message_at', 'desc')
        ->limit(10)
        ->get();
    return response()->json($sessions);
});

// Public API for user to poll admin replies
Route::get('/api/chat/{sessionId}/messages/{lastId}', function($sessionId, $lastId = 0) {
    $messages = \App\Models\ChatMessage::where('session_id', $sessionId)
        ->where('id', '>', $lastId)
        ->orderBy('created_at', 'asc')
        ->get();
    return response()->json($messages);
});

// Public API for admin widget to load messages (same as admin route but public)
Route::get('/api/admin/chat/{sessionId}/messages/{lastId?}', function($sessionId, $lastId = 0) {
    $messages = \App\Models\ChatMessage::where('session_id', $sessionId)
        ->where('id', '>', $lastId)
        ->orderBy('created_at', 'asc')
        ->get();
    return response()->json($messages);
});

// RajaOngkir API Routes
Route::get('/api/provinces', [App\Http\Controllers\Api\RegionController::class, 'getProvinces']);
Route::get('/api/cities', [App\Http\Controllers\Api\RegionController::class, 'getCities']);
Route::get('/api/districts', [App\Http\Controllers\Api\RegionController::class, 'getDistricts']);
Route::get('/api/villages', [App\Http\Controllers\Api\RegionController::class, 'getVillages']);
Route::post('/api/shipping-cost', [App\Http\Controllers\Api\RegionController::class, 'getShippingCost']);
