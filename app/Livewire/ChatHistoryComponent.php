<?php

namespace App\Livewire;

use App\Events\PrivateChatEvent;
use App\Models\Friendship;
use App\Models\Message;
use App\Models\VoiceMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ChatHistoryComponent extends Component
{
    public $friends = [];
    public $latestMessage;
    public $receiverId;
    public $selectedUser = null;
    public $isTyping = false;
    public $selectedFriendId = null;

    protected $listeners = [
        "echo-private:chat.{authUserId},PrivateChatEvent" => 'listenForMessage',
        "echo-private:typing.{authUserId},UserTypingEvent" => 'handleTypingEvent',
    ];

    public function getAuthUserIdProperty()
    {
        return Auth::id();
    }

    public function listenForMessage($event): void
    {
        $this->latestMessage = $event['message'];

        // Find the friend that the message belongs to and update the latest message
        foreach ($this->friends as &$friend) {
            if ($friend['id'] == $event['message']['sender_id']) {
                // Determine the message content based on the type
                if ($event['type'] == 'text') {
                    $latestMessageContent = $event['message']['message'];
                } elseif ($event['type'] == 'voice') {
                    $latestMessageContent = '[Voice Message]';
                } else {
                    $latestMessageContent = '[Unknown Message Type]';
                }

                // Update the latest message content and time
                $friend['latest_message'] = $latestMessageContent;
                $friend['latest_message_time'] = \Carbon\Carbon::parse($event['message']['created_at'])->diffForHumans();

                // Handle unread counts and message seen status
                if ($friend['id'] !== $this->selectedFriendId) {
                    $friend['unread_count'] += 1;  // Increment unread count
                } else {
                    // Mark the message as read immediately
                    if ($event['type'] == 'text') {
                        Message::where('id', $event['message']['id'])->update(['is_seen' => true]);
                    } elseif ($event['type'] == 'voice') {
                        VoiceMessage::where('id', $event['message']['id'])->update(['is_seen' => true]);
                    }
                }
            }
        }

        $this->dispatch('unreadMessagesUpdated');
    }

    public function mount()
    {
        $this->fetchFriends();
    }

    public function fetchFriends()
    {
        $friendships = Friendship::where(function ($query) {
            $query->where('friend_id', Auth::id())
                ->orWhere('user_id', Auth::id());
        })
            ->where('status', 'accepted')
            ->with([
                'user' => function ($query) {
                    $query->with('profile');
                },
                'friend' => function ($query) {
                    $query->with('profile');
                },
                'user.sentMessages' => function ($query) {
                    $query->latest();
                },
                'friend.sentMessages' => function ($query) {
                    $query->latest();
                }
            ])
            ->get();

        $this->friends = [];

        foreach ($friendships as $friendship) {
            if ($friendship->user_id == Auth::id()) {
                $friend = $friendship->friend;
            } else {
                $friend = $friendship->user;
            }

            $latestMessage = $friend->sentMessages->first();

            // Count unread messages for this friend
            $unreadCount = Message::where('sender_id', $friend->id)
                ->where('receiver_id', Auth::id())
                ->where('is_seen', false)
                ->count();

            $this->friends[] = [
                'id' => $friend->id,
                'name' => $friend->name,
                'online' => $friend->online,
                'profile_image' => $friend->profile->profile_image ?? 'default.png',
                'bio' => $friend->profile->bio ?? '',
                'latest_message' => $latestMessage->message ?? 'No messages',
                'latest_message_time' => $latestMessage ? $latestMessage->created_at->diffForHumans() : null,
                'unread_count' => $unreadCount,
            ];
        }
    }

    public function selectUser($userId, $name): void
    {
        $this->selectedUser = ['id' => $userId, 'name' => $name];
        $this->selectedFriendId = $userId;

        $unseenMessages = Message::where('sender_id', $userId)
            ->where('receiver_id', Auth::id())
            ->where('is_seen', false)
            ->get();

        foreach ($unseenMessages as $unseenMessage) {
            $unseenMessage->is_seen = true;
            $unseenMessage->save();

            broadcast(new PrivateChatEvent($unseenMessage->fresh(), $unseenMessage->sender_id, 'text'));
        }
        $unseenVoices = VoiceMessage::where('sender_id', $userId)
            ->where('receiver_id', Auth::id())
            ->where('is_seen', false)
            ->get();

        foreach ($unseenVoices as $unseenVoice) {
            $unseenVoice->is_seen = true;
            $unseenVoice->save();

            broadcast(new PrivateChatEvent($unseenVoice->fresh(), $unseenVoice->sender_id, 'voice'));
        }

        // Reset unread count for this friend
        foreach ($this->friends as &$friend) {
            if ($friend['id'] == $userId) {
                $friend['unread_count'] = 0;
            }
        }

        // Reassign the friends array to trigger reactivity
        $this->friends = array_values($this->friends);

        $this->dispatch('unreadMessagesUpdated');
        $this->dispatch('userSelected', $userId)->to('main-layout-component');
    }

    public function handleTypingEvent($event): void
    {
        try {
            $senderId = $event['senderId'];
            $isTyping = $event['isTyping'];

            $this->isTyping[$senderId] = $isTyping;

        } catch (\Exception $e) {
            Log::error('Error in handleTypingEvent: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.chat-history-component');
    }
}
