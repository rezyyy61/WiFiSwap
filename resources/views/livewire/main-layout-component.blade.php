<div class="h-screen">
    <div class="grid grid-cols-[90px_450px_1fr] h-full">
        <!-- Left column for icons -->
        <div class="bg-white flex flex-col items-center py-4 h-full justify-between w-full rounded-lg shadow-lg border">
            <!-- Top: Logo -->
            <div class="mb-8">
                <img src="logo W/w-logo-zip-file/png/logo-no-background.png" alt="Logo" class="h-10 w-10">
            </div>

            <!-- Middle: Icons -->
            <div class="flex flex-col items-center space-y-6 w-full">
                <!-- chat Icon -->
                <div class="relative cursor-pointer p-2 rounded-lg flex justify-center items-center transition duration-300 hover:bg-[#FFEFEF]
    @if($currentView === 'home') text-black @else text-gray-400 @endif"
                     wire:click="showHome">

                    <!-- The icon SVG -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor"
                         class="@if($currentView !== 'home') w-8 text-gray-400 @else w-12 p-2 text-[#FD625E] bg-[#FFEFEF] @endif">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155"/>
                    </svg>

                    <!-- Notification badge -->
                    @if($unreadCount > 0)
                        <div class="absolute top-1 right-1 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                            {{$unreadCount}}
                        </div>
                    @endif
                </div>


                <!-- Chatroom SVG Icon -->
                <div class="cursor-pointer p-2 rounded-lg flex justify-center items-center transition duration-300 hover:bg-[#FFEFEF]
                    @if($currentView === 'chatRoom') text-black @else text-gray-400 @endif"
                     wire:click="showChatRoom">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                         class="@if($currentView !== 'chatRoom') w-8 text-gray-400 @else w-12 p-2 text-[#FD625E] bg-[#FFEFEF] @endif">>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                    </svg>
                </div>

                <!-- Settings Icon -->
                <div class="cursor-pointer p-2 rounded-lg flex justify-center items-center transition duration-300 hover:bg-[#FFEFEF]
                    @if($currentView === 'settings') text-black @else text-gray-400 hover:text-gray-600 @endif"
                     wire:click="showChatRoomSame">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor"
                         class="@if($currentView !== 'settings') w-8 text-gray-400 @else w-12 p-2 text-[#FD625E] bg-[#FFEFEF] @endif">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155"/>
                    </svg>
                </div>

                <!-- Mail Icon -->
                <div class="cursor-pointer w-full text-center p-2 rounded-lg transition duration-300
                    @if($currentView === 'mail') text-black @else text-gray-400 hover:text-gray-600 @endif">
                    📧
                </div>
            </div>

            <!-- Bottom: User Profile -->
            <div class="mt-8 relative cursor-pointer" wire:click="notification" wire:poll.15s="fetchNotifications">
                <img src="https://via.placeholder.com/40"
                     alt="User Profile"
                     class="h-12 w-12 rounded-full mb-2 relative p-1
         @if($notifications)
             border-2 border-[#FD625E]
         @endif">
                @if($notifications)
                    <span class="absolute top-0 right-0 transform translate-x-1/4 -translate-y-1/4 text-[#FD625E] text-xl animate-shake">
            ❤️
        </span>
                @endif
            </div>



        </div>

        <!-- Middle column for dynamic content -->
        <div class="bg-[#fedcdb33]">
            @if($currentView === 'home')
                <livewire:ChatHistoryComponent/>
            @elseif($currentView === 'chatRoom')
                <livewire:OnlineUsersComponent/>
            @elseif($currentView === 'notification')
                <livewire:Notification/>
            @endif
        </div>

        <!-- Right column for the chat UI -->
        <div class="flex justify-center h-screen w-full">
            @if($currentView === 'home')
                <livewire:PrivateChatComponent/>
            @elseif($currentView === 'chatRoom')
                <livewire:ChatRoomSameIpComponent/>
            @elseif($currentView === 'notification')
                <livewire:ProfileLayouteComponent/>
            @endif
        </div>
    </div>
</div>
