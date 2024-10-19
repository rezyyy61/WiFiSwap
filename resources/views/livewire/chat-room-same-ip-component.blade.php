<div class="flex w-full">
    <!-- Chat window with custom scrollbar -->
    <div class="flex-1 px-5 flex flex-col">
        <div class="flex flex-col h-full">
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
                            <div class="flex justify-end gap-2.5">
                                <div class="flex flex-col gap-1 w-full max-w-[320px]" oncontextmenu="showContextMenu(event, {{ $message['id'] }})">
                                    <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                        <span class="text-sm font-normal text-gray-500 dark:text-gray-400">{{ $message['created_at']->format('H:i') }}</span>
                                    </div>
                                    <div class="flex flex-col leading-1.5 p-4 border-gray-200 bg-blue-500 rounded-e-xl rounded-es-xl dark:bg-gray-700">
                                        <p class="text-sm font-normal text-gray-900 dark:text-white">{{ $message['message'] }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Custom context menu -->
                            <div id="contextMenu-{{ $message['id'] }}" class="hidden z-10 bg-white divide-y divide-gray-100 rounded-lg shadow w-40 dark:bg-gray-700 dark:divide-gray-600 absolute">
                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownMenuIconButton">
                                    <li>
                                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Reply</a>
                                    </li>
                                    <li>
                                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Forward</a>
                                    </li>
                                    <li>
                                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Copy</a>
                                    </li>
                                    <li>
                                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Report</a>
                                    </li>
                                    <li>
                                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Delete</a>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <div class="flex items-start gap-2.5">
                                <img style="background-color: {{ $message['image_background_color'] }};"
                                     class="w-12 h-12 rounded-full" src="" alt="">
                                <div class="flex flex-col gap-1 w-full max-w-[320px]" oncontextmenu="showContextMenu(event, {{ $message['id'] }})">
                                    <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                        <span class="text-m font-semibold text-gray-900 ">{{ $message['user_name'] }}</span>
                                        <span class="text-sm font-normal text-gray-500 dark:text-gray-400">{{ $message['created_at']->format('H:i') }}</span>
                                    </div>
                                    <div class="flex flex-col leading-1.5 p-4 border-gray-200 bg-gray-100 rounded-e-xl rounded-es-xl dark:bg-gray-700">
                                        <p class="text-sm font-normal text-gray-900 dark:text-white">{{ $message['message'] }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Custom context menu -->
                            <div id="contextMenu-{{ $message['id'] }}" class="hidden z-10 bg-white divide-y divide-gray-100 rounded-lg shadow w-40 dark:bg-gray-700 dark:divide-gray-600 absolute">
                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownMenuIconButton">
                                    <li>
                                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Reply</a>
                                    </li>
                                    <li>
                                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Forward</a>
                                    </li>
                                    <li>
                                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Copy</a>
                                    </li>
                                    <li>
                                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Report</a>
                                    </li>
                                    <li>
                                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Delete</a>
                                    </li>
                                </ul>
                            </div>

                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Input area shown only for today's chat rooms -->
            @if($isToday)
                <div class="m-4">
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
            @endif
        </div>
    </div>

    <!-- Chat Groups Sidebar -->
    <div class="w-1/4 border-l-2 px-5">
        <div class="flex flex-col">
            <div class="font-semibold text-xl py-4">Groups</div>
            @foreach($chatRooms as $chatRoom)
                <div class="flex flex-row py-4 px-2 items-center border-b-2">
                    <div class="w-1/4">
                        <img
                            wire:click="selectChatRoom({{ $chatRoom['id'] }})"
                            style="background-color: {{ $chatRoom['logo'] }};"
                            src="#"
                            class="object-cover h-12 w-12 rounded-full cursor-pointer"
                            alt=""
                        />
                    </div>
                    <div class="w-full">
                        <div
                            wire:click="selectChatRoom({{ $chatRoom['id'] }})"
                            class="text-lg font-semibold cursor-pointer">{{ $chatRoom['name'] }}</div>
                        <span class="text-gray-500">{{ $chatRoom['created_at'] }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    window.addEventListener('scrollDown', () => {
        let container = document.querySelector('#chatRoom');
        setTimeout(() => {
            container.scrollTop = container.scrollHeight;
        }, 100);
    });

    function showContextMenu(event, messageId) {
        event.preventDefault(); // Prevent default right-click menu

        // Hide all open context menus
        document.querySelectorAll('[id^="contextMenu-"]').forEach(menu => menu.classList.add('hidden'));

        // Get the specific context menu for the message
        const contextMenu = document.getElementById(`contextMenu-${messageId}`);

        // Position the menu at the mouse click location
        contextMenu.style.top = `${event.pageY}px`;
        contextMenu.style.left = `${event.pageX}px`;

        // Show the menu
        contextMenu.classList.remove('hidden');
    }

    // Hide context menu when clicking elsewhere
    window.addEventListener('click', function() {
        document.querySelectorAll('[id^="contextMenu-"]').forEach(menu => menu.classList.add('hidden'));
    });
</script>
