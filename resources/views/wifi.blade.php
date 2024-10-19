<x-app-layout>
    <div class="container mx-auto shadow-lg rounded-lg mt-10">
        <!-- header -->
        <div class="px-5 py-5 flex justify-between items-center bg-white border-b-2">
            <div class="font-semibold text-2xl">GoingChat</div>
            <div class="w-1/2">
                <input
                    type="text"
                    name=""
                    id=""
                    placeholder="search IRL"
                    class="rounded-2xl bg-gray-100 py-3 px-5 w-full"
                />
            </div>
            <div
                class="h-12 w-12 p-2 bg-yellow-500 rounded-full text-white font-semibold flex items-center justify-center"
            >
                RA
            </div>
        </div>

        <!-- Chatting Section -->
        <div class="flex flex-row justify-between bg-white">

            <!-- Sidebar: Online Users -->
            <div class="flex flex-col w-max[200] border-r-2 overflow-y-auto">

                <!-- Online Users Heading -->
                <div class="border-b-2 py-4 px-2">
                    <h2 class="text-xl font-semibold text-gray-700 flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Online Users</span>
                    </h2>
                </div>

                <!-- Search for Users -->
                <div class="border-b-2 py-4 px-2">
                    <input
                        type="text"
                        placeholder="Search users"
                        class="py-2 px-2 border-2 border-gray-200 rounded-2xl w-full"
                    />
                </div>

                <!-- Online Users List -->
                <livewire:online-users-component/>
            </div>

            <!-- Chat Room -->
                <livewire:chat-room-same-ip-component/>

        </div>
    </div>
</x-app-layout>

