<div class="rounded-lg shadow-lg h-screen bg-[#fedcdb33]">
    <h1 class="m-4 font-bold text-2xl">Chats</h1>
    <!-- Search Form -->
    <livewire:FriendSearch/>

    <!-- Chat History -->
    <div class="mt-6 w-full h-[calc(100vh-200px)] overflow-y-auto ">
        @foreach($friends as $friend)
        <div wire:click="selectUser({{ $friend['id']}}, '{{ $friend['name'] }}')"
             class="flex items-center px-4 py-5 cursor-pointer border shadow hover:bg-[#f7939033]">
            <img class="h-10 w-10 rounded-full" src="https://via.placeholder.com/150" alt="Avatar">
            <div class="ml-3">
                <p class="text-sm font-semibold">{{$friend['name']}}</p>
                <p class="text-xs text-gray-500">{{ $friend['latest_message'] }}</p>
            </div>
            <span class="ml-auto text-xs text-gray-400">{{ $friend['latest_message_time'] }}</span>
            @if($friend['online'])
                <span class="w-2 h-2 ml-2 bg-green-500 rounded-full"></span>
            @endif
        </div>
        @endforeach
    </div>

</div>
