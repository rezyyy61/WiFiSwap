<div id="messagesContainer" class="flex items-center w-full p-4 bg-gray-100 rounded-lg  space-x-2">
    <form wire:submit.prevent="sendMessage" class="flex items-center w-full p-4 bg-gray-100 rounded-lg space-x-2">
        <!-- Sticker Button -->
        <button type="button" class="p-2 text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                <path d="M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z"/>
                <path d="M16.5 10.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zm-6 0a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM12 14.75c1.5 0 4 0.75 4 2.25H8c0-1.5 2.5-2.25 4-2.25z" fill="#000"/>
            </svg>
        </button>

        <!-- File/Image Upload Button -->
        <label class="p-2 text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer">
            <input type="file" class="hidden" accept="image/*, .pdf, .doc, .docx" />
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m7-7H5" />
            </svg>
        </label>

        <!-- Text Input -->
        <input
            id="message"
            wire:model.live="message"
            type="text"
            name="message"
            placeholder="Enter Message..."
            wire:keydown.enter="sendMessage"
            class="flex-1 p-2 text-gray-700 bg-white border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
        />

        <!-- Voice Button -->
        <button type="button" class="p-2 text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 3a3 3 0 00-3 3v6a3 3 0 106 0V6a3 3 0 00-3-3zM7 11.25V12c0 2.76 2.24 5 5 5s5-2.24 5-5v-.75M8.5 19h7m-7-1v1m7-1v1" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>

        <!-- Send Button -->
        <button type="submit" class="p-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7-7 7M5 12h16" />
            </svg>
        </button>
    </form>
</div>

