<div class="">
    <form id="message-form" wire:submit.prevent="sendMessage" class="border-t border-gray-300 p-4 flex items-center space-x-4">
        <input
            id="message"
            wire:model.live="message"
            type="text"
            name="message"
            placeholder="Enter Message..."
            wire:keydown.enter="sendMessage"
            class="w-full px-4 py-2 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500">

        <!-- Paperclip Icon -->
        <button type="button" class="text-blue-500" title="Attach File">
            <!-- SVG Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.25 9.75l-6 6M9 15.25l-6-6"/>
            </svg>
        </button>

        <!-- Smile Icon -->
        <button type="button" class="text-blue-500" title="Emoji">
            <!-- SVG Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 14.5c1.19 0 2.194.314 2.977.825.768.501 1.223 1.184 1.223 1.675 0 .765-.618 1.5-1.365 1.5-2.03 0-3.835-1.04-3.835-3.5z"/>
            </svg>
        </button>

        <!-- Send Icon -->
        <button
            type="submit" class="bg-blue-500 text-white p-2 rounded-full" title="Send">
            <!-- SVG Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M21.75 11.25l-9.5 9.5M21.75 11.25l-9.5-9.5M21.75 11.25H7.25m0 9.5L15 12.5"/>
            </svg>
        </button>
    </form>
</div>

<script>
    window.addEventListener('scrollDown', () => {
        let container = document.querySelector('#chatRoom');
        setTimeout(() => {
            container.scrollTop = container.scrollHeight;
        }, 100);
    });

    window.addEventListener('clearMessageInput', () => {
        const inputField = document.querySelector('#message');
        if (inputField) {
            inputField.value = '';
        }
    });
</script>
