<div>
    <div class="flex items-center w-4/5 mx-auto bg-[#fedcdb]">
        <label for="simple-search" class="sr-only">Search</label>
        <div class="relative w-full">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <!-- Search Icon -->
            </div>
            <input type="text"
                   id="simple-search"
                   wire:model.live="query"
                   class="bg-[#fedcdb] text-gray-700 text-lg rounded-lg focus:ring-[#FD625E] block w-full pl-10 pr-14 py-3 outline-none border"
                   placeholder="Search users..." required/>
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
