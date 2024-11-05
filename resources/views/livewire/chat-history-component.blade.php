<div class="w-full">
    <form class="flex items-center mt-8 max-w-fit mx-auto ">
        <label for="simple-search" class="sr-only">Search</label>
        <div class="relative w-full">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 5v10M3 5a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm0 10a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm12 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm0 0V6a3 3 0 0 0-3-3H9m1.5-2-2 2 2 2" />
                </svg>
            </div>
            <input type="text" id="simple-search"
                   class="bg-[#5F5F7F]  text-white text-lg rounded-lg  w-full pl-10 pr-14 py-3 "
                   placeholder="Search branch name..." required />

            <!-- Search Button -->
            <button type="submit"
                    class="absolute inset-y-0 right-0 flex items-center p-2 text-sm font-medium text-white  rounded-lg">
                <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                </svg>
                <span class="sr-only">Search</span>
            </button>
        </div>
    </form>

    <!-- Recent Chats - Vertical Scroll Only -->
    <ul class="my-8 w-full">
        <li class="cursor-pointer group text-xs text-gray-400 hover:text-white font-semibold w-full">
            <div class="h-20 bg-[#38385f] group-hover:bg-[#38385f] rounded-lg mb-1">
                <!-- save messages -->
{{--                <div wire:click="selectUser('save', 'Save Messages')"--}}
{{--                    class="flex items-center cursor-pointer ">--}}

{{--                    <!-- Image Container -->--}}
{{--                    <div class="relative flex-shrink-0">--}}
{{--                        <!-- Friend Profile Image -->--}}
{{--                        <img class="w-10 h-10 rounded" src="/docs/images/people/profile-picture-5.jpg" alt="">--}}
{{--                    </div>--}}

{{--                    <!-- Friend Information -->--}}
{{--                    <div class="ml-4 flex-1 overflow-hidden">--}}
{{--                        <p class="text-lg md:text-base font-semibold text-white font-poppins truncate">Save Messages</p>--}}
{{--                    </div>--}}

{{--                    <!-- Right Side - Time and Unread Messages -->--}}
{{--                    <div class="text-right relative flex flex-col items-end ml-auto">--}}
{{--                        <!-- Message Time -->--}}
{{--                        <span--}}
{{--                            class="text-xs md:text-sm text-[#6B7280] font-poppins"></span>--}}
{{--                    </div>--}}
{{--                </div>--}}
                @foreach($friends as $friend)
                    <div wire:click="selectUser({{ $friend['id'] }}, '{{ $friend['name'] }}')"
                         class="p-3 flex items-center justify-between border-t cursor-pointer hover:bg-[#5F5F7F] {{$friend['id'] === $selectedFriendId ? 'bg-[#5F5F7F]' : ''}}">
                        <div class="flex items-center">
                            <img class="rounded h-10 w-10" src="https://loremflickr.com/g/600/600/girl">
                            <div class="ml-2 flex flex-col">
                                <div class="leading-snug text-sm text-white font-bold">{{ $friend['name'] }}</div>
                                <div class="leading-snug text-xs text-gray-200">
                                    @if($friend['id'] == $selectedFriendId)
                                        Chatting now...
                                    @elseif($friend['id'] !== $selectedFriendId && isset($isTyping[$friend['id']]) && $isTyping[$friend['id']])
                                        <em>typing...</em>
                                    @else
                                        {{ $friend['latest_message'] }}
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- Right Side - Time and Unread Messages -->
                        <div class="text-right relative flex flex-col items-end ml-auto">
                            <!-- Message Time -->
                            <span
                                class="text-xs md:text-sm text-[#6B7280] font-poppins">{{ $friend['latest_message_time'] }}</span>

                            <!-- Unread Message Count -->
                            @if($friend['unread_count'] > 0)
                                <div class="mt-1">
                                                <span
                                                    class="px-2 py-1 text-red-500 rounded-full bg-red-500/20 text-xs font-bold">
                                                    {{ $friend['unread_count'] }}
                                                </span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </li>
    </ul>
</div>
