<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\ChatMessage;
use App\Models\ChatMessageAttachment;
use App\Models\ChatMessageStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(Conversation $conversation): JsonResponse
    {
        $messages = ChatMessage::where('conversation_id', $conversation->id)
            ->with(['sender:id,first_name,last_name,email'])
            ->orderByDesc('id')
            ->paginate(50);

        return response()->json(['data' => $messages], 200);
    }

    public function store(Request $request, Conversation $conversation): JsonResponse
    {
        $data = $request->validate([
            'body' => 'nullable|string',
            'encrypted_payload' => 'nullable|string',
            'message_type' => 'nullable|string|in:text,file,system,event',
            'reply_to_id' => 'nullable|integer|exists:chat_messages,id',
        ]);

        $message = ChatMessage::create([
            'conversation_id' => $conversation->id,
            'sender_id' => Auth::id(),
            'body' => $data['body'] ?? null,
            'encrypted_payload' => $data['encrypted_payload'] ?? null,
            'message_type' => $data['message_type'] ?? 'text',
            'reply_to_id' => $data['reply_to_id'] ?? null,
            'created_by' => Auth::id(),
        ]);

        ChatMessageStatus::create([
            'message_id' => $message->id,
            'user_id' => Auth::id(),
            'status' => 'sent',
            'sent_at' => now(),
        ]);

        return response()->json(['data' => $message], 201);
    }

    public function markRead(ChatMessage $message): JsonResponse
    {
        ChatMessageStatus::updateOrCreate(
            ['message_id' => $message->id, 'user_id' => Auth::id()],
            ['status' => 'read', 'read_at' => now()]
        );

        return response()->json(null, 204);
    }

    public function markDelivered(ChatMessage $message): JsonResponse
    {
        ChatMessageStatus::updateOrCreate(
            ['message_id' => $message->id, 'user_id' => Auth::id()],
            ['status' => 'delivered', 'delivered_at' => now()]
        );

        return response()->json(null, 204);
    }

    public function delete(ChatMessage $message): JsonResponse
    {
        $message->update(['deleted_at' => now(), 'deleted_by' => Auth::id()]);

        return response()->json(null, 204);
    }

    public function deleteForEveryone(ChatMessage $message): JsonResponse
    {
        $message->update([
            'deleted_at' => now(),
            'deleted_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        return response()->json(null, 204);
    }

    public function search(Request $request): JsonResponse
    {
        $query = $request->validate(['q' => 'nullable|string']);

        $results = ChatMessage::query()
            ->where('body', 'like', '%'.($query['q'] ?? '').'%')
            ->with(['sender:id,first_name,last_name,email', 'conversation:id,name'])
            ->limit(50)
            ->get();

        return response()->json(['data' => $results], 200);
    }

    public function uploadAttachment(Request $request, ChatMessage $message): JsonResponse
    {
        $request->validate([
            'file' => 'required|file|max:10240',
        ]);

        $path = $request->file('file')->store('chat_attachments', 'local');

        $attachment = ChatMessageAttachment::create([
            'message_id' => $message->id,
            'file_name' => $request->file('file')->getClientOriginalName(),
            'file_path' => $path,
            'file_type' => $request->file('file')->getClientMimeType(),
            'file_size' => $request->file('file')->getSize(),
            'created_by' => Auth::id(),
        ]);

        return response()->json(['data' => $attachment], 201);
    }

    public function previewAttachment(ChatMessageAttachment $attachment): JsonResponse
    {
        return response()->json(['data' => $attachment], 200);
    }

    public function downloadAttachment(ChatMessageAttachment $attachment): JsonResponse
    {
        return response()->download(storage_path('app/'.$attachment->file_path), $attachment->file_name);
    }
}