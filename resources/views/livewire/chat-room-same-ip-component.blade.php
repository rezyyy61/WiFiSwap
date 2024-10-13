<div>
    <!-- Chat window with custom scrollbar -->
    <div id="chatRoom"
         class="overflow-y-auto h-96 scrollbar-custom scrollbar-thumb-gray-400 scrollbar-track-transparent">
        @foreach($messages as $message)
            <div class="flex flex-col mt-5">
                @if($message['sender_id'] === Auth::id())
                    <div class="flex justify-end mb-4">
                        <div
                            class="mr-2 py-3 px-4 bg-gradient-to-r from-blue-400 to-blue-500 rounded-bl-3xl rounded-tl-3xl rounded-tr-xl text-white shadow-md"
                        >
                            {{ $message['message'] }}
                        </div>
                    </div>
                @else
                    <div class="flex justify-start mb-4">
                        <div class="object-cover h-10 w-10 rounded-full shadow-md"
                             style="background-color: {{ $message['image_background_color'] }};">
                            <img
                                src="https://source.unsplash.com/vpOeXr5wmR4/600x600"
                                class="h-full w-full rounded-full"
                            alt=""
                            />
                        </div>
                        <div class="ml-4">
                            <div
                                class="py-2 px-3 bg-gradient-to-r from-gray-500 to-gray-500 rounded-br-3xl rounded-tr-3xl rounded-tl-xl text-white shadow-md"
                            >
                                <strong style="color: {{ $message['user_color'] }};" class="block">
                                    {{ $message['user_name'] }}
                                </strong>
                                {{ $message['message'] }}
                            </div>
                        </div>
                    </div>

                @endif
            </div>
        @endforeach
    </div>

    <!-- Message input area -->
    <div class="py-5">
        <form id="message-form" wire:submit.prevent="sendMessage" class="mt-4">
            <label for="chat" class="sr-only">Your message</label>
            <div class="flex items-center px-2 py-1">
                <textarea wire:key="message-textarea-{{ now()->timestamp }}" wire:model="message" rows="1"
                          class="w-full bg-gray-200 py-4 px-4 rounded-xl resize-none shadow-inner focus:outline-none focus:ring-2 focus:ring-blue-400"
                          placeholder="Type your message..."></textarea>
                <button type="submit"
                        class="ml-2 inline-flex items-center justify-center p-3 bg-blue-500 text-white rounded-full shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <svg class="w-5 h-5 rotate-90 rtl:-rotate-90" aria-hidden="true"
                         xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                        <path
                            d="m17.914 18.594-8-18a1 1 0 0 0-1.828 0l-8 18a1 1 0 0 0 1.157 1.376L8 18.281V9a1 1 0 0 1 2 0v9.281l6.758 1.689a1 1 0 0 0 1.156-1.376Z"/>
                    </svg>
                    <span class="sr-only">Send message</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    window.addEventListener('scrollDown', () => {
        let container = document.querySelector('#chatRoom');
        setTimeout(() => {
            container.scrollTop = container.scrollHeight;
        }, 100);
    });
</script>
