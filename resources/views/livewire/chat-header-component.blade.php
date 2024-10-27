<div class="flex items-center justify-between p-4 border-b border-gray-300">
    <div class="flex items-center space-x-3">
        <img src="https://via.placeholder.com/40" class="w-10 h-10 rounded-full" alt="">
        <span class="font-bold text-lg">{{ $receiverName ?? 'Select a User' }}</span>
        @if($receiverId)
            <span class="text-green-500">&#9679;</span>
        @endif
    </div>
    <div class="flex space-x-4">
        <!-- Search Icon -->
        <button class="text-gray-500" title="Search">
            <!-- SVG Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </button>
        <!-- Phone Icon -->
        <button class="text-gray-500" title="Call">
            <!-- SVG Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M3 5h6l1 9H2L3 5zm2 10h2v2H5v-2zm11 0h2v2h-2v-2z"/>
            </svg>
        </button>
        <!-- Video Icon -->
        <button class="text-gray-500" title="Video Call">
            <!-- SVG Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M3 8h10v8H3V8z"/>
            </svg>
        </button>
        <!-- Users Icon -->
        <button class="text-gray-500" title="Users">
            <!-- SVG Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M17 20h5v-2a4 4 0 00-4-4H7a4 4 0 00-4 4v2h16zM7 10a4 4 0 100-8 4 4 0 000 8zm10 0a4 4 0 100-8 4 4 0 000 8z"/>
            </svg>
        </button>
        <!-- Ellipsis Icon -->
        <button class="text-gray-500" title="More Options">
            <!-- SVG Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 6.75a1.5 1.5 0 110-3 1.5 1.5 0 010 3zm0 7.5a1.5 1.5 0 110-3 1.5 1.5 0 010 3zm0 7.5a1.5 1.5 0 110-3 1.5 1.5 0 010 3z"/>
            </svg>
        </button>
    </div>
</div>

