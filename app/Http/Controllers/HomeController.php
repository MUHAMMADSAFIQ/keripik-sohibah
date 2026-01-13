<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Testimonial;
use App\Models\Partner;
use App\Models\Message;
use App\Models\ChatMessage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::where('is_ready', true)->get();
        $featuredProducts = $products->take(3);
        $testimonials = Testimonial::where('is_approved', true)->latest()->get();
        $partners = Partner::all();
        
        return view('home', compact('featuredProducts', 'products', 'testimonials', 'partners'));
    }

    public function menu()
    {
        $products = Product::where('is_ready', true)->get();
        return view('menu', compact('products'));
    }

    public function contact()
    {
        return view('contact');
    }
    
    public function storeMessage(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'message' => 'required',
        ]);
        
        Message::create($request->all());
        
        return back()->with('success', 'Pesan berhasil dikirim!');
    }

    public function mitra()
    {
        $partners = Partner::all();
        return view('mitra', compact('partners'));
    }

    public function geminiChat(Request $request)
    {
        Log::info("Chat: User Request received", $request->all());
        
        try {
            $input = $request->input('message');
            $sessionId = $request->input('session_id', session()->getId());
            $userName = $request->input('user_name');
            $userPhone = $request->input('user_phone');
            
            if (empty($input)) {
                return response()->json(['error' => 'Pesan tidak boleh kosong'], 400);
            }

            // Check Admin Online Status
            $adminOnline = Cache::get('admin_online', false);
            
            // Check if this is indeed the first message (or restart)
            $isFirstMessage = ChatMessage::where('session_id', $sessionId)->doesntExist();

            // Save User Message
            $userMessage = ChatMessage::create([
                'session_id' => $sessionId,
                'sender_type' => 'user',
                'message' => $input,
                'is_read' => false,
                'admin_online' => $adminOnline,
                'user_name' => $userName,
                'user_phone' => $userPhone
            ]);
            
            // Auto-reply for first message
            if ($isFirstMessage) {
                ChatMessage::create([
                    'session_id' => $sessionId,
                    'sender_type' => 'ai',
                    'message' => 'Halo! Terima kasih sudah menghubungi Keripik Sohibah. Admin kami akan segera membalas pesan Kakak secepatnya. Mohon ditunggu ya! 😊',
                    'is_read' => true,
                    'user_name' => $userName,
                    'user_phone' => $userPhone
                ]);
            }
            
            // NOTE: AI Auto-reply is DISABLED to support direct Admin-User chat flow.
            // The message is saved, and the user must wait for an Admin reply.
            
            return response()->json([
                'reply' => null, // No AI reply
                'show_wa' => false,
                'session_id' => $sessionId,
                'read_status' => false, // Wait for admin to read
                'last_message_id' => $userMessage->id
            ]);

        } catch (\Throwable $e) {
            Log::error('Chat Controller Error: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            
            return response()->json([
                'error' => 'Maaf, terjadi kesalahan koneksi. ' . (env('APP_DEBUG') ? $e->getMessage() : 'Silakan coba lagi.'),
            ], 500);
        }
    }

    public function getMessages($lastId, Request $request)
    {
        $sessionId = $request->query('session_id', session()->getId());
        
        $messages = \App\Models\ChatMessage::where('session_id', $sessionId)
            ->where('id', '>', $lastId)
            ->where('sender_type', '!=', 'user') 
            ->orderBy('created_at', 'asc')
            ->get();
            
        return response()->json($messages);
    }
}
