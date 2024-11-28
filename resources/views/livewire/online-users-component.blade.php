{{--<div class=" p-5 rounded-lg shadow-lg h-screen">--}}
{{--    <form class="flex items-center max-w-sm mx-auto bg-[#fedcdb]">--}}
{{--        <label for="simple-search" class="sr-only">Search</label>--}}
{{--        <div class="relative w-full">--}}
{{--            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">--}}
{{--                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">--}}
{{--                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"--}}
{{--                          d="M3 5v10M3 5a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm0 10a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm12 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm0 0V6a3 3 0 0 0-3-3H9m1.5-2-2 2 2 2" />--}}
{{--                </svg>--}}
{{--            </div>--}}
{{--            <input type="text" id="simple-search"--}}
{{--                   class="bg-[#fedcdb] text-gray-700 text-lg rounded-lg focus:ring-[rgb(42_181_125)] block w-full pl-10 pr-14 py-3 outline-none border border-[#caeddf33]"--}}
{{--                   placeholder="Search branch name..." required />--}}

{{--            <!-- Search Button -->--}}
{{--            <button type="submit"--}}
{{--                    class="absolute inset-y-0 right-0 flex items-center p-2 text-sm font-medium text-white bg-[#fedcdb] rounded-lg hover:bg-[#F7ADAA] focus:ring-4 focus:outline-none">--}}
{{--                <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">--}}
{{--                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"--}}
{{--                          d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />--}}
{{--                </svg>--}}
{{--                <span class="sr-only">Search</span>--}}
{{--            </button>--}}
{{--        </div>--}}
{{--    </form>--}}

{{--    <!-- Chat Rooms Section -->--}}
{{--    <div class="overflow-hidden mt-5">--}}
{{--        <div class="overflow-x-auto whitespace-nowrap hover:overflow-x-scroll transition duration-300">--}}
{{--            <div class="inline-flex space-x-4 p-2">--}}
{{--                @foreach($chatRooms as $chatroom)--}}
{{--                    <div class="cursor-pointer relative flex flex-col items-center bg-white rounded-lg p-4 shadow-md border border-[#caeddf33] transition duration-300 ease-in-out hover:shadow-lg transform hover:scale-105">--}}
{{--                        <!-- Chat Room Avatar -->--}}
{{--                        <div class="relative">--}}
{{--                            <img class="w-14 h-14 rounded-full shadow-md border border-[#caeddf33]" src="logo W/w-logo-zip-file/png/logo-no-background.png" alt="{{ $chatroom['name'] }}">--}}
{{--                            <div class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-[rgb(42_181_125)] border-2 border-white rounded-full"></div>--}}
{{--                        </div>--}}
{{--                        <!-- Chat Room Name -->--}}
{{--                        <span class="text-gray-700 text-sm font-bold mt-3">{{ $chatroom['name'] }}</span>--}}

{{--                        <!-- Message Notification Badge -->--}}
{{--                        <div class="absolute top-2 right-2 flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full">--}}
{{--                            3 <!-- Example number of unread messages -->--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                @endforeach--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <!-- Online Users Section -->--}}
{{--    <div class="mt-8">--}}
{{--        <h3 class="text-xl font-semibold text-gray-800 mb-4">Currently Online</h3>--}}
{{--        <div wire:poll.25s="refreshOnlineUsers" class="grid grid-cols-4 gap-2">--}}
{{--            @foreach($onlineUsers as $onlineUser)--}}
{{--                <div class="flex flex-col items-center transform cursor-pointer transition hover:scale-125 duration-300">--}}
{{--                    <img class="w-14 h-14 rounded-full border-2 border-[#FD625E]" src="{{ $onlineUser['profile']['profile_image'] ?? '' }}" alt="">--}}
{{--                    <span class="text-[#FD625E] text-sm font-bold mt-3">{{ $onlineUser['name'] }}</span>--}}
{{--                </div>--}}
{{--            @endforeach--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
<div></div>
