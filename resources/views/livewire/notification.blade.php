<div class="rounded-lg shadow-lg h-screen " style="background-color: #f4fbf9;">

    <h1 class=" m-4 text-xl font-semibold text-gray-800 mb-4">Add New User</h1>
    <!-- Search Results -->
    <div>
        <div class="flex items-center w-4/5 mx-auto bg-[#fedcdb] m-4">
            <label for="simple-search" class="sr-only">Search</label>
            <div class="relative w-full">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input type="text" id="simple-search"
                       wire:model.live="query"
                       class="bg-[#CAEDDF] text-gray-700 text-lg rounded-lg focus:ring-[rgb(42_181_125)] block w-full pl-10 pr-14 py-3 outline-none border border-[#caeddf33]"
                       placeholder="Search branch name..." required />
            </div>
        </div>

        <!-- Status Message -->
        @if ($statusMessage)
            <div class="mb-4 text-green-600">
                {{ $statusMessage }}
            </div>
        @endif

        <!-- Search Results -->
        <div class="mt-4 max-h-64 overflow-y-auto ">
            @if (empty($searchResults) && $query != '')
                <div>No users found.</div>
            @else
                <ul>
                    @foreach ($searchResults as $user)
                        <li class=" mb-3 flex justify-between items-center px-2 py-2 rounded-lg shadow-md">
                            <div>
                                <p class="text-sm font-semibold">{{ $user->name }}</p>

                            </div>

                            <!-- Send Friend Request Button -->
                            <button
                                wire:click="sendFriendRequest({{ $user->id }})"
                                class="py-1 hover:bg-[#f7939033] rounded-lg"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-[#FD625E]">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                                </svg>
                            </button>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
    <!-- notification -->
    <h1 class=" m-4 text-xl font-semibold text-gray-800 mb-4">Notifications</h1>
    <div wire:poll="fetchNotifications" class="mt-4 max-h-64 overflow-y-auto">
        @foreach ($notifications as $notification)
            <!-- Each notification is displayed in its own container -->
            <div class="flex items-center px-4 py-5 cursor-pointer hover:bg-[#f7939033]">
                <img class="h-10 w-10 rounded-full" src="https://via.placeholder.com/150" alt="Avatar">
                <div class="ml-3">
                    <p class="text-sm font-semibold">{{ $notification['name'] }}</p>
                    <p class="text-xs text-gray-500">{{ $notification['timestamp'] }}</p>
                </div>
                <span class="ml-auto text-xs text-gray-400">
                    <!-- Accept Button -->
                    <button class="py-1 hover:bg-[#f7939033] rounded-lg"
                    wire:click="acceptRequest({{ $notification['id'] }})">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-green-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z" />
                        </svg>
                    </button>
                    <!-- Reject Button -->
                    <button class="py-1 hover:bg-[#f7939033] rounded-lg"
                    wire:click="declineRequest({{ $notification['id'] }})"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-[#FD625E]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.498 15.25H4.372c-1.026 0-1.945-.694-2.054-1.715a12.137 12.137 0 0 1-.068-1.285c0-2.848.992-5.464 2.649-7.521C5.287 4.247 5.886 4 6.504 4h4.016a4.5 4.5 0 0 1 1.423.23l3.114 1.04a4.5 4.5 0 0 0 1.423.23h1.294M7.498 15.25c.618 0 .991.724.725 1.282A7.471 7.471 0 0 0 7.5 19.75 2.25 2.25 0 0 0 9.75 22a.75.75 0 0 0 .75-.75v-.633c0-.573.11-1.14.322-1.672.304-.76.93-1.33 1.653-1.715a9.04 9.04 0 0 0 2.86-2.4c.498-.634 1.226-1.08 2.032-1.08h.384m-10.253 1.5H9.7m8.075-9.75c.01.05.027.1.05.148.593 1.2.925 2.55.925 3.977 0 1.487-.36 2.89-.999 4.125m.023-8.25c-.076-.365.183-.75.575-.75h.908c.889 0 1.713.518 1.972 1.368.339 1.11.521 2.287.521 3.507 0 1.553-.295 3.036-.831 4.398-.306.774-1.086 1.227-1.918 1.227h-1.053c-.472 0-.745-.556-.5-.96a8.95 8.95 0 0 0 .303-.54" />
                        </svg>
                    </button>
                </span>
            </div>
        @endforeach
    </div>
</div>
