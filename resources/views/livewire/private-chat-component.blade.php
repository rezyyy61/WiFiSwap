<div id="chatRoom" class="bg-white h-full w-full  grid grid-rows-[auto_1fr_auto] rounded-tr-2xl hidden md:grid">
    <!-- Chat Header Fixed at the Top -->
    <div class="w-full z-10 top-0">
        <livewire:chat-header-component :receiverId="$receiverId"/>
    </div>

    <!-- Messages List - Scrollable Middle Section -->
    <div class="overflow-y-auto w-full">
        <!-- Chat Section -->
        <div id="messagesContainer" class="flex-grow overflow-y-auto h-full p-6 space-y-4 w-full bg-[#fedcdb33]">
            @foreach($messages as $message)
                <!-- Other user's message (left side with image) -->
                @if($message['sender_id'] !== Auth::id() && !empty($message['message']))
                    <div wire:key="message-{{ $message['id'] }}" class="flex items-start space-x-3">
                        <img src="https://cataas.com/cat" class="w-8 h-8 rounded" alt="">
                        <div class="bg-[#2AB57D] p-2 rounded-lg max-w-3xl text-white font-bold px-4">
                            <p>{{ $message['message'] }}</p>
                            <span class="text-xs text-gray-300">{{ \Carbon\Carbon::parse($message['created_at'])->format('H:i') }}</span>
                        </div>
                    </div>
                @endif

                <!-- Current user's message (right side without image) -->
                @if($message['sender_id'] === Auth::id())
                    <div wire:key="message-{{ $message['id'] }}" class="flex items-start justify-end space-x-3">
                        <div class="bg-[#EFF2F7] p-2 rounded-lg text-black font-bold max-w-3xl px-4">
                            <p>{{ $message['message'] }}</p>
                            <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($message['created_at'])->format('H:i') }}</span>
                            @if(!$message['is_seen'])
                                <!-- Not Seen Icon -->
                                <span class="text-xs text-gray-300 ml-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-gray-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                            </svg>
                        </span>
                            @else
                                <!-- Seen Icon -->
                                <span class="text-xs text-gray-300 ml-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-blue-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15L15 9.75M21 12a9 9 0 11-9-9 9 9 0 019 9z"/>
                            </svg>
                        </span>
                            @endif
                        </div>
                    </div>
                @endif
            @endforeach

            <!-- Typing Indicator for Other User -->
                @if(isset($isTyping[$receiverId]) && $isTyping[$receiverId])
                <div class="flex items-center space-x-3">
                    <img src="https://via.placeholder.com/40" class="w-8 h-8 rounded-full" alt="">
                    <div class="bg-[#2AB57D] p-2 rounded-lg max-w-3xl text-white font-bold px-4 animate-pulse">
                        <p><em>typing...</em></p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Message Input Fixed at the Bottom -->
    <div class="w-full z-10 bottom-0">
        <livewire:message-input-component :receiverId="$receiverId" :key="'message-input-'.$receiverId"/>
    </div>
</div>

