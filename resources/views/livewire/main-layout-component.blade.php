<div class="flex h-screen font-[sans-serif]">
    <!-- Left column for icons -->
    <div class="bg-[#2e2e48] py-8 px-4 h-full min-w-[80px] w-[90px] flex flex-col items-center">
        <img src='https://readymadeui.com/profile_6.webp' class="w-12 h-12 cursor-pointer rounded-full border-2 border-white" />

            <ul class="my-12 flex flex-col space-y-10 flex-1">
                <li
                    class="w-12 h-12 flex items-center justify-center cursor-pointer text-xl text-white font-semibold bg-[#ff7979] rounded-lg
                        @if($currentView === 'home')
                        text-black
                    @else
                        text-gray-400
                    @endif"
                    wire:click="showHome">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor"
                         class="w-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155"/>
                    </svg>

                    @if($unreadCount > 0)
                        <div
                            class="absolute top-1 right-1 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                            {{$unreadCount}}
                        </div>
                    @endif
                </li>
                <li
                    class="w-12 h-12 flex items-center justify-center cursor-pointer text-xl text-white font-semibold bg-[#c95eff] rounded-lg
                          @if($currentView === 'chatRoom')
                        text-black
                    @else
                        text-gray-400
                    @endif"
                    wire:click="showChatRoom">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor"
                         class="w-6">
                        >
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z"/>
                    </svg>
                </li>
                <li
                    class="w-12 h-12 flex items-center justify-center cursor-pointer text-xl text-white font-semibold bg-[#077bff] rounded-lg">
                    C
                </li>
            </ul>

            <button type='button'
                    class="w-12 h-12 py-6 flex items-center justify-center cursor-pointer text-xl text-white font-semibold bg-[#fff] rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#333" class="w-5 h-5" viewBox="0 0 6.35 6.35">
                    <path
                        d="M3.172.53a.265.266 0 0 0-.262.268v2.127a.265.266 0 0 0 .53 0V.798A.265.266 0 0 0 3.172.53zm1.544.532a.265.266 0 0 0-.026 0 .265.266 0 0 0-.147.47c.459.391.749.973.749 1.626 0 1.18-.944 2.131-2.116 2.131A2.12 2.12 0 0 1 1.06 3.16c0-.65.286-1.228.74-1.62a.265.266 0 1 0-.344-.404A2.667 2.667 0 0 0 .53 3.158a2.66 2.66 0 0 0 2.647 2.663 2.657 2.657 0 0 0 2.645-2.663c0-.812-.363-1.542-.936-2.03a.265.266 0 0 0-.17-.066z"
                        data-original="#000000"></path>
                </svg>
            </button>
        </div>


    <!-- Middle column for dynamic content -->
    <div class="bg-[#38385f] py-8 px-4 h-full w-[900px] overflow-auto flex flex-col items-center">
        <a href="javascript:void(0)">
            <img src="https://readymadeui.com/readymadeui-white.svg" alt="logo" class='w-[160px]' />
        </a>

        @if($currentView === 'home')
            <livewire:ChatHistoryComponent/>
        @elseif($currentView === 'chatRoom')
            <livewire:OnlineUsersComponent/>
        @elseif($currentView === 'notification')
            <livewire:Notification/>
        @endif
    </div>

    <!-- Right column for the chat UI, hidden on smaller screens -->
    <div class="bg-white  h-full flex flex-col w-full items-center rounded-tr-2xl hidden md:flex">
        @if($currentView === 'home')
            <livewire:PrivateChatComponent/>
        @elseif($currentView === 'chatRoom')
            <livewire:ChatRoomSameIpComponent/>
        @elseif($currentView === 'notification')
            <livewire:ProfileLayouteComponent/>
        @else
            <div class="flex items-center justify-center h-full w-full">
                <p class="text-gray-500 text-lg">Please select a user to start chatting.</p>
            </div>
        @endif
    </div>
</div>
