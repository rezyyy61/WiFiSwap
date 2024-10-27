<?php

namespace App\Livewire;

use Livewire\Component;

class PrivateChatComponent extends Component
{
    public $receiverId = null;
    protected $listeners = ['userSelected' => 'loadUserChat'];

    public function loadUserChat($userData)
    {
        $this->receiverId = $userData['id'];
    }

    public function render()
    {
        return view('livewire.private-chat-component');
    }

}





//public $receiverId = null;
//public $isTyping = false;
//public $receiverName;
//public $messages = [];
//public $message = '';
//
//public $isOtherUserTyping = false;
//public $typingUserName = '';
//
//protected $listeners = [
//    'userSelected' => 'loadUserChat',
//    "echo-private:chat.{authUserId},PrivateChatEvent" => 'listenForMessage',
//    "echo-private:typing.{authUserId},UserTypingEvent" => 'listenForTyping',
//    'chatBoxVisible' => 'markMessagesAsSeen',
//    'resetTyping' => 'resetTypingIndicator',
//    'checkTypingTimeout' => 'checkTypingTimeout',
//];
//
//// Add a computed property for authUserId
//public function getAuthUserIdProperty()
//{
//    return Auth::id();
//}
//
//public function loadUserChat($userData)
//{
//    $this->receiverId = $userData['id'];
//    $this->receiverName = $userData['name'];
//    $this->dispatch('scrollDown');
//    $this->resetTypingIndicator();
//    $this->loadMessages();
//}
//
//public function loadMessages()
//{
//    if ($this->receiverId) {
//        // Load messages between authenticated user and selected user
//        $this->messages = Message::where(function ($query) {
//            $query->where('sender_id', Auth::id())
//                ->where('receiver_id', $this->receiverId);
//        })->orWhere(function ($query) {
//            $query->where('sender_id', $this->receiverId)
//                ->where('receiver_id', Auth::id());
//        })->orderBy('created_at', 'asc')->get();
//
//        // Mark unseen messages as seen if they are from the receiver
//        $unseenMessages = $this->messages->where('sender_id', $this->receiverId)
//            ->where('receiver_id', Auth::id())
//            ->where('is_seen', false);
//
//        foreach ($unseenMessages as $unseenMessage) {
//            $unseenMessage->is_seen = true;
//            $unseenMessage->save();
//
//            // Optionally broadcast the message seen event back to the sender
//            broadcast(new PrivateChatEvent($unseenMessage, $unseenMessage->sender_id))->toOthers();
//        }
//    }
//}

//public function listenForMessage($event): void
//{
//    $newMessageData = $event['message'];
//    $messageId = $newMessageData['id'] ?? null;
//
//    if (!$messageId) {
//        Log::error('Message ID is missing in event data.', $newMessageData);
//        return;
//    }
//
//    // Fetch the message from the database to ensure we are working with a model instance
//    $messageInDb = Message::find($messageId);
//
//    if (!$messageInDb) {
//        Log::error('Message not found in database.', ['message_id' => $messageId]);
//        return;
//    }
//
//    // Proceed if the message is between the current user and the selected user
//    if (
//        ($messageInDb->sender_id == $this->receiverId && $messageInDb->receiver_id == Auth::id()) ||
//        ($messageInDb->sender_id == Auth::id() && $messageInDb->receiver_id == $this->receiverId)
//    ) {
//        // If the message is from the receiver, mark it as seen
//        if ($messageInDb->sender_id == $this->receiverId && $messageInDb->receiver_id == Auth::id()) {
//            if (!$messageInDb->is_seen) {
//                $messageInDb->is_seen = true;
//                $messageInDb->save();
//
//                // Broadcast the message seen event back to the sender
//                broadcast(new PrivateChatEvent($messageInDb, $messageInDb->sender_id))->toOthers();
//            }
//        }
//
//        // Update or add the message in the local messages collection
//        $existingMessageKey = collect($this->messages)->search(function ($message) use ($messageId) {
//            return $message->id == $messageId;
//        });
//
//        if ($existingMessageKey !== false) {
//            // Update existing message in the collection
//            $this->messages[$existingMessageKey] = $messageInDb;
//        } else {
//            // Add the new message as an Eloquent model instance
//            $this->messages->push($messageInDb);
//        }
//
//        // Reassign the messages collection to trigger reactivity
//        $this->messages = $this->messages->values();
//
//        $this->dispatch('scrollDown');
//    }
//}
//
//public function listenForTyping($event)
//{
//    // Ensure the typing event is from the current receiver
//    if ($event['senderId'] === $this->receiverId) {
//        $this->isOtherUserTyping = true;
//        $this->typingUserName = $event['senderName'];
//
//        // Hide the typing indicator after a delay (e.g., 3 seconds)
//        $this->dispatch('hideTypingIndicator', ['timeout' => 3000]);
//    }
//}
//
//public function resetTypingIndicator()
//{
//    $this->isOtherUserTyping = false;
//    $this->typingUserName = '';
//}
//
//public function markMessagesAsSeen()
//{
//    if ($this->receiverId) {
//        $unseenMessages = Message::where('sender_id', $this->receiverId)
//            ->where('receiver_id', Auth::id())
//            ->where('is_seen', false)
//            ->get();
//
//        foreach ($unseenMessages as $unseenMessage) {
//            $unseenMessage->is_seen = true;
//            $unseenMessage->save();
//
//            // Optionally broadcast back to the sender that the message is seen
//            broadcast(new PrivateChatEvent($unseenMessage, $unseenMessage->sender_id))->toOthers();
//        }
//    }
//}
//
//public function userTyping()
//{
//    if ($this->receiverId) {
//        $senderId = Auth::id();
//        $receiverId = $this->receiverId;
//        $senderName = Auth::user()->name;
//
//        // Broadcast the typing event
//        broadcast(new UserTypingEvent($senderId, $receiverId, $senderName))->toOthers();
//    }
//}
//
//public function checkTypingTimeout()
//{
//    $this->isOtherUserTyping = false;
//    $this->typingUserName = '';
//}
//
//public function render()
//{
//    return view('livewire.private-chat-component');
//}
