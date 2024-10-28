<div class="rounded-lg shadow-lg h-screen " style="background-color: #f4fbf9;">
    <h1 class="m-4 font-bold text-2xl" style="color: #1A5319; font-family: 'Helvetica Neue', sans-serif;">Chats</h1>
    <!-- Search Form -->
    <form class="flex items-center max-w-sm mx-auto bg-[#CAEDDF] mb-4 rounded-md">
        <label for="simple-search" class="sr-only">Search</label>
        <div class="relative w-full">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                </svg>
            </div>
            <input type="text" id="simple-search"
                   class="bg-[#CAEDDF] text-gray-700 text-lg rounded-lg focus:ring-[rgb(42_181_125)] block w-full pl-10 pr-14 py-3 outline-none border border-[#caeddf33]"
                   placeholder="Search branch name..." required/>
        </div>
    </form>

    <!-- Favorite Contacts -->
    <div class="flex space-x-4 m-6 overflow-x-auto">
        @foreach(['Patrick', 'Doris', 'Emily', 'Steve'] as $favorite)
            <div class="flex flex-col items-center min-w-max relative">
                <img class="h-14 w-14 rounded-full border-2" src="https://via.placeholder.com/100" alt="{{ $favorite }}"
                     style="border-color: #508D4E;">
                <span class="mt-2 text-sm font-bold"
                      style="color: #1A5319; font-family: 'Poppins', sans-serif;">{{ $favorite }}</span>
            </div>
        @endforeach
    </div>

    <!-- Recent Chats -->
    <div class="">
        <h2 class="m-3 font-bold text-lg" style="color: #1A5319; font-family: 'Poppins', sans-serif;">Recent</h2>
        <div class="">
            @foreach($friends as $friend)
                <div wire:click="selectUser({{ $friend['id'] }}, '{{ $friend['name'] }}')"
                     class="flex items-center py-4 px-5 cursor-pointer transition-all duration-300 ease-in-out hover:bg-[#d7f2e8] hover:mx-3 hover:rounded-xl {{ $friend['id'] == $selectedFriendId ? 'bg-[#d7f2e8] mx-3 rounded-xl' : 'bg-[#f4fbf9]' }}">

                    <!-- Image Container -->
                    <div class="relative">
                        <!-- Friend Profile Image -->
                        <img
                            class="h-12 w-12 rounded-full {{ $friend['online'] ? 'border-[#508D4E]' : 'border-[#D1D5DB]' }}"
                            src="{{ $friend['profile_image'] ? asset($friend['profile_image']) : 'https://via.placeholder.com/150' }}"
                            alt="">

                        <!-- Online Status Indicator -->
                        @if($friend['online'])
                            <span class="absolute top-0 right-0 w-3 h-3 rounded-full bg-[#508D4E] border-2 border-white"></span>
                        @endif
                    </div>

                    <div class="ml-4 flex-1">
                        <p class="text-base font-semibold text-[#1A5319] font-poppins">{{ $friend['name'] }}</p>
                        <p class="text-sm font-poppins animate-pulse {{ $friend['id'] == $selectedFriendId ? 'text-[#508D4E]' : 'text-[#6B7280]' }}">
                            @if($friend['id'] == $selectedFriendId)
                                Chatting now...
                            @elseif($friend['id'] !== $selectedFriendId && isset($isTyping[$friend['id']]) && $isTyping[$friend['id']])
                            <em>typing...</em>
                            @else
                                {{ $friend['latest_message'] }}
                            @endif
                        </p>
                    </div>


                    <div class="text-right relative flex flex-col items-end">
                        <!-- Message Time -->
                        <span class="text-xs text-[#6B7280] font-poppins">{{ $friend['latest_message_time'] }}</span>

                        <!-- Unread Message Count -->
                        @if($friend['unread_count'] > 0)
                            <div class="mt-1">
                                <span class="px-2 py-1 text-red-500 rounded-full bg-red-500/20 text-xs font-bold">
                                    {{ $friend['unread_count'] }}
                                </span>
                            </div>
                        @endif
                    </div>

                </div>
            @endforeach
        </div>
    </div>
</div>
