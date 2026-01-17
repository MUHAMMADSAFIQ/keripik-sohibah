<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $fillable = [
        'session_id',
        'sender_type',
        'message',
        'is_read',
        'admin_online',
        'read_at',
        'user_name',
        'user_phone'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'admin_online' => 'boolean',
        'read_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Get read status icon
    public function getReadStatusAttribute()
    {
        if ($this->sender_type !== 'user') {
            return null; // Only for user messages
        }

        if ($this->is_read) {
            return 'read'; 
        } elseif ($this->admin_online) {
            return 'delivered'; 
        } else {
            return 'sent'; 
        }
    }

    // Scope untuk pesan belum dibaca
    public function scopeUnread($query)
    {
        return $query->where('is_read', false)->where('sender_type', 'user');
    }

    // Scope untuk session tertentu
    public function scopeForSession($query, $sessionId)
    {
        return $query->where('session_id', $sessionId)->orderBy('created_at', 'asc');
    }
}
