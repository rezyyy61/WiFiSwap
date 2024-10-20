<div class="flex w-full">
    <div class="w-full mx-auto flex flex-col">
        <!-- Header Section -->
        <div class="flex items-center justify-between p-4 border-b border-gray-300">
            <div class="flex items-center space-x-3">
                <img src="https://via.placeholder.com/40" class="w-10 h-10 rounded-full" alt="#">
                <span class="font-bold text-lg">{{ $receiverName ?? 'Select a User' }}</span>
                <span class="text-green-500">&#9679;</span>
            </div>
            <div class="flex space-x-4">
                <!-- Search Icon -->
                <button class="text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
                <!-- Phone Icon -->
                <button class="text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3 5h6l1 9H2L3 5zm2 10h2v2H5v-2zm11 0h2v2h-2v-2z" />
                    </svg>
                </button>
                <!-- Video Icon -->
                <button class="text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M3 8h10v8H3V8z" />
                    </svg>
                </button>
                <!-- Users Icon -->
                <button class="text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M17 20h5v-2a4 4 0 00-4-4H7a4 4 0 00-4 4v2h16zM7 10a4 4 0 100-8 4 4 0 000 8zm10 0a4 4 0 100-8 4 4 0 000 8z" />
                    </svg>
                </button>
                <!-- Ellipsis Icon -->
                <button class="text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 6.75a1.5 1.5 0 110-3 1.5 1.5 0 010 3zm0 7.5a1.5 1.5 0 110-3 1.5 1.5 0 010 3zm0 7.5a1.5 1.5 0 110-3 1.5 1.5 0 010 3z" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Chat Section -->
        <div id="chatRoom" class="flex-grow overflow-y-auto p-6 space-y-4 w-full bg-[#fedcdb33]">
            @foreach($messages as $message)
                <!-- Other user's message (left side with image) -->
                @if($message['sender_id'] !== Auth::id() && !empty($message['message']))
                    <div class="flex items-start space-x-3">
                        <img src="https://via.placeholder.com/40" class="w-10 h-10 rounded-full" alt="Patricia Smith">
                        <div class="bg-red-200 p-3 rounded-lg max-w-3xl text-black">
                            <p>{{ $message['message'] }}</p>
                            <span class="text-xs text-gray-500">{{ $message['created_at']->format('H:i') }}</span>
                        </div>
                    </div>
                @endif

                <!-- Current user's message (right side without image) -->
                @if($message['sender_id'] === Auth::id())
                    <div class="flex items-start justify-end space-x-3">
                        <div class="bg-blue-100 p-3 rounded-lg text-black max-w-3xl">
                            <p>{{ $message['message'] }}</p>
                            <span class="text-xs text-gray-500">{{ $message['created_at']->format('H:i') }}</span>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <!-- Input Section -->
        <div class="">

                <form id="message-form" wire:submit.prevent="sendMessage" class="border-t border-gray-300 p-4 flex items-center space-x-4">
                    <input wire:key="message-textarea-{{ now()->timestamp }}" wire:model="message" type="text" placeholder="Enter Message..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500">

                    <!-- Paperclip Icon -->
                    <button class="text-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.25 9.75l-6 6M9 15.25l-6-6" />
                        </svg>
                    </button>

                    <!-- Smile Icon -->
                    <button class="text-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 14.5c1.19 0 2.194.314 2.977.825.768.501 1.223 1.184 1.223 1.675 0 .765-.618 1.5-1.365 1.5-2.03 0-3.835-1.04-3.835-3.5z" />
                        </svg>
                    </button>

                    <!-- Paper Plane Icon -->
                    <button class="bg-blue-500 text-white p-2 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M21.75 11.25l-9.5 9.5M21.75 11.25l-9.5-9.5M21.75 11.25H7.25m0 9.5L15 12.5" />
                        </svg>
                    </button>
                </form>
        </div>
    </div>
</div>

<script>
    window.addEventListener('scrollDown', () => {
        console.log('scrollDown event received');
        let container = document.querySelector('#chatRoom');
        console.log('container:', container);
        setTimeout(() => {
            if (container) {
                container.scrollTop = container.scrollHeight;
            } else {
                console.error('Chat container not found!');
            }
        }, 100);
    });
</script>

