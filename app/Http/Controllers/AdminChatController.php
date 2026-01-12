<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AdminChatController extends Controller
{
    // Tampilkan semua chat sessions
    public function index(Request $request)
    {
        // Get unique sessions grouped strictly by session_id
        $sessions = ChatMessage::select('session_id')
            ->selectRaw('MAX(created_at) as last_message_at')
            ->selectRaw('SUM(CASE WHEN is_read = 0 AND sender_type = "user" THEN 1 ELSE 0 END) as unread_count')
            ->groupBy('session_id')
            ->orderBy('last_message_at', 'desc')
            ->get();

        // Attach User Data (Avatar & Details)
        $sessions->transform(function($session) {
            // Default placeholder
            $session->avatar = null;
            $session->user_name = 'Guest';
            $session->user_phone = '-';
            
            // Format time for API
            $session->time_ago = \Carbon\Carbon::parse($session->last_message_at)->diffForHumans();

            // 1. Try to get info from latest chat message history
            $lastMsg = ChatMessage::where('session_id', $session->session_id)
                ->whereNotNull('user_name')
                ->orderBy('created_at', 'desc')
                ->first();
            
            // Get last message text for preview
            $session->last_message = ChatMessage::where('session_id', $session->session_id)->orderBy('created_at', 'desc')->value('message');
            
            if ($lastMsg) {
                $session->user_name = $lastMsg->user_name;
                $session->user_phone = $lastMsg->user_phone;
            }

            // 2. If it is a registered user session, Override with Real User Data
            if (str_starts_with($session->session_id, 'user_')) {
                $userId = substr($session->session_id, 5);
                $user = \App\Models\User::find($userId);
                if ($user) {
                    $session->avatar = $user->avatar;
                    $session->user_name = $user->name; 
                    $session->user_phone = $user->phone;
                }
            }
            // Fallback avatar URL for JSON
            if(empty($session->avatar)) {
                $session->avatar_url = 'https://ui-avatars.com/api/?name='.urlencode($session->user_name).'&background=random';
            } else {
                $session->avatar_url = $session->avatar;
            }
            
            return $session;
        });

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json($sessions);
        }

        return view('admin.chat.index', compact('sessions'));
    }

    // Tampilkan detail chat session
    public function show($sessionId, Request $request)
    {
        // Mark as read
        ChatMessage::where('session_id', $sessionId)
            ->where('sender_type', 'user')
            ->where('is_read', false)
            ->update(['is_read' => true]);
            
        // Set admin online status for this session
        // (Optional: Bisa pakai Cache global)
        
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true]);
        }

        $session = (object)['session_id' => $sessionId];
        
        // Coba cari nama user dari history
        $lastMsg = ChatMessage::where('session_id', $sessionId)
                    ->whereNotNull('user_name')
                    ->orderBy('created_at', 'desc')
                    ->first();
                    
        if ($lastMsg) {
            $session->user_name = $lastMsg->user_name;
            $session->user_phone = $lastMsg->user_phone;
        }

        // Cek user registered
        if (str_starts_with($sessionId, 'user_')) {
             $userId = substr($sessionId, 5);
             $user = \App\Models\User::find($userId);
             if ($user) {
                 $session->user_name = $user->name;
                 $session->user_phone = $user->phone;
                 $session->avatar = $user->avatar;
             }
        }

        $messages = ChatMessage::where('session_id', $sessionId)
            ->orderBy('created_at', 'asc') // Oldest first
            ->get();

        return view('admin.chat.show', compact('session', 'messages', 'sessionId'));
    }

    // Admin kirim pesan
    public function sendMessage(Request $request, $sessionId)
    {
        try {
            $request->validate([
                'message' => 'required|string'
            ]);

            $message = ChatMessage::create([
                'session_id' => $sessionId,
                'sender_type' => 'admin',
                'message' => $request->message,
                'is_read' => true, // Admin message always read
                'admin_online' => true
            ]);

            return response()->json([
                'success' => true,
                'message' => $message
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Get new messages (polling)
    public function getNewMessages($sessionId, $lastId = 0)
    {
        $messages = ChatMessage::where('session_id', $sessionId)
            ->where('id', '>', $lastId)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }

    // Set admin online status
    public function setOnlineStatus(Request $request)
    {
        $isOnline = $request->boolean('online');
        Cache::put('admin_online', $isOnline, now()->addHours(1));
        
        return response()->json(['success' => true, 'online' => $isOnline]);
    }

    // Check if admin is online
    public function checkAdminOnline()
    {
        $isOnline = Cache::get('admin_online', false);
        return response()->json(['online' => $isOnline]);
    }
}
