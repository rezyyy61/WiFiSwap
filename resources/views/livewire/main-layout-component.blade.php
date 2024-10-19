<div class="h-screen bg-gradient-to-r from-[#E8F5E9] to-[#C8E6C9]">
    <div class="grid grid-cols-[90px_500px_1fr] h-full gap-4">
        <!-- Left column for icons -->
        <div class="bg-[#A5D6A7] flex flex-col items-center py-4 h-full justify-between w-full rounded-lg shadow-lg border border-[#A5D6A7]">
            <!-- Top: Logo -->
            <div class="mb-8">
                <img src="logo W/w-logo-zip-file/png/logo-no-background.png" alt="Logo" class="h-10 w-10">
            </div>

            <!-- Middle: Icons -->
            <div class="flex flex-col items-center space-y-6 w-full">
                <!-- Home Icon -->
                <div class="text-[#388E3C] cursor-pointer w-full text-center hover:bg-[#C8E6C9] p-2 rounded-lg transition duration-300"
                     wire:click="showHome">
                    🏠
                </div>

                <!-- Chatroom SVG Icon -->
                <div class="cursor-pointer hover:bg-[#C8E6C9] p-2 rounded-lg flex justify-center items-center transition duration-300"
                     wire:click="showChatRoom">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 text-[#388E3C]">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                    </svg>
                </div>

                <!-- Settings Icon -->
                <div class="text-[#388E3C] cursor-pointer w-full text-center hover:bg-[#C8E6C9] p-2 rounded-lg transition duration-300"
                     wire:click="showChatRoomSame">
                    ⚙️
                </div>

                <!-- Mail Icon -->
                <div class="text-[#388E3C] cursor-pointer w-full text-center hover:bg-[#C8E6C9] p-2 rounded-lg transition duration-300">
                    📧
                </div>
            </div>

            <!-- Bottom: User Profile -->
            <div class="mt-8">
                <img src="https://via.placeholder.com/40" alt="User Profile" class="h-10 w-10 rounded-full mb-2">
            </div>
        </div>

        <!-- Middle column for users -->
        <div class="bg-white p-6 rounded-lg shadow-lg border border-[#A5D6A7]">
            @if($currentView === 'home')
                <livewire:ChatRoomSameIpComponent/>
            @elseif($currentView === 'chatRoom')
                <livewire:OnlineUsersComponent/>
            @endif
        </div>

        <!-- Right column for the rest -->
        <div class="bg-white p-6 rounded-lg shadow-lg border border-[#A5D6A7]">
            <h2 class="text-xl font-bold mb-4 text-[#388E3C]">Additional Information</h2>
            <p class="text-[#5B5B5B]">This is the right column for extra content or other elements you want to add.</p>
            <div class="mt-4 space-y-2">
                <div class="p-4 bg-[#A5D6A7] border border-[#A5D6A7] rounded-lg">Detail 1</div>
                <div class="p-4 bg-[#A5D6A7] border border-[#A5D6A7] rounded-lg">Detail 2</div>
                <div class="p-4 bg-[#A5D6A7] border border-[#A5D6A7] rounded-lg">Detail 3</div>
            </div>
        </div>
    </div>
</div>
