<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        "message_id", "client_id", "is_bot", "chat_id", "message", "is_command"
    ];


    public static function getMessage(int $id, int $chat_id, int $client_id): ?Message
    {
        return Message::where("message_id", $id)
            ->when($chat_id, fn($query) => $query->where("chat_id", $chat_id))
            ->when($client_id, fn($query) => $query->where("client_id", $client_id))
            ->first();
    }

    // TODO: need improve (add option to get last message only from the client)
    public static function lastInChat(int $chat_id): ?Message
    {
        return Message::where("chat_id", $chat_id)
            ->orderBy('message_id','desc')->first();
    }
}
