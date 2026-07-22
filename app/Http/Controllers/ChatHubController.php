<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ChatHubController extends Controller
{
    /**
     * Display the Chat HUB workspace.
     *
     * Conversation and message data is static placeholder content for the
     * approved UI shell; it will be wired to real conversation/message
     * queries once the chat backend (models, services, APIs) is built.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $conversations = $this->demoConversations();

        return view('chathub.index', [
            'currentUser' => [
                'name' => $user->name,
                'initials' => $this->initials($user->name),
            ],
            'conversations' => $conversations,
            'activeConversation' => Arr::first($conversations, fn ($conversation) => $conversation['active']),
            'messages' => $this->demoMessages(),
        ]);
    }

    private function initials(string $name): string
    {
        $parts = preg_split('/\s+/', trim($name)) ?: [];
        $initials = strtoupper(mb_substr($parts[0] ?? '', 0, 1).mb_substr($parts[1] ?? '', 0, 1));

        return $initials !== '' ? $initials : 'U';
    }

    private function demoConversations(): array
    {
        return [
            [
                'id' => 'manage-chat',
                'name' => 'Manage Chat',
                'role' => 'Group • 14 members',
                'avatar' => 'MC',
                'color' => 'green',
                'tags' => ['group', 'unread', 'secure'],
                'secure' => true,
                'preview' => 'Leave policy review is ready for approval.',
                'time' => '2m',
                'unread' => 4,
                'presence' => 'online',
                'active' => true,
            ],
            [
                'id' => 'payroll-operations',
                'name' => 'Payroll Operations',
                'role' => 'Department group',
                'avatar' => 'PO',
                'color' => '',
                'tags' => ['group', 'secure'],
                'secure' => true,
                'preview' => 'Payroll lock summary has been shared.',
                'time' => '8m',
                'unread' => 0,
                'presence' => 'online',
                'active' => false,
            ],
            [
                'id' => 'kavya-shah',
                'name' => 'Kavya Shah',
                'role' => 'Product Designer',
                'avatar' => 'KS',
                'color' => 'purple',
                'tags' => ['unread', 'secure'],
                'secure' => true,
                'preview' => 'Dark theme component state has been updated.',
                'time' => '18m',
                'unread' => 1,
                'presence' => 'online',
                'active' => false,
            ],
            [
                'id' => 'support-desk',
                'name' => 'Support Desk',
                'role' => 'Support group',
                'avatar' => 'SD',
                'color' => 'orange',
                'tags' => ['group', 'unread'],
                'secure' => false,
                'preview' => 'Ticket #482 was assigned to the HR team.',
                'time' => '44m',
                'unread' => 2,
                'presence' => 'idle',
                'active' => false,
            ],
            [
                'id' => 'finance-review',
                'name' => 'Finance Review',
                'role' => 'Private channel',
                'avatar' => 'FR',
                'color' => 'red',
                'tags' => ['group', 'secure'],
                'secure' => true,
                'preview' => 'Budget PDF is available for download.',
                'time' => '3h',
                'unread' => 0,
                'presence' => 'offline',
                'active' => false,
            ],
        ];
    }

    private function demoMessages(): array
    {
        return [
            [
                'mine' => false,
                'sender' => 'Anita R.',
                'avatar' => 'AR',
                'text' => 'Can we send the leave policy update after confirming approval from department heads?',
                'time' => '10:16 AM',
                'status' => 'Delivered',
            ],
            [
                'mine' => true,
                'sender' => 'You',
                'avatar' => 'ME',
                'text' => 'Yes. Please keep the announcement short and attach the approved policy PDF.',
                'time' => '10:18 AM',
                'status' => 'Read ✓✓',
            ],
            [
                'mine' => false,
                'sender' => 'Nikhil V.',
                'avatar' => 'NV',
                'text' => 'I have attached the approval summary and policy document.',
                'time' => '10:21 AM',
                'status' => 'Delivered',
                'attachment' => [
                    'type' => 'PDF',
                    'name' => 'leave-policy-summary.pdf',
                    'meta' => 'Encrypted file • 286 KB',
                ],
            ],
            [
                'mine' => true,
                'sender' => 'You',
                'avatar' => 'ME',
                'text' => 'Reviewed. Please proceed and keep this conversation pinned until the rollout is complete.',
                'time' => '10:24 AM',
                'status' => 'Sent ✓',
            ],
        ];
    }
}
