<x-app-layout>
    <div class="flex p-5 space-x-4">
        <!-- Left Side -->
        <div class="w-1/4 p-4 rounded-l-lg shadow-md">
            <p class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Online Users</p>

            <livewire:online-users-component/>

        </div>

        <!-- Main Content (Right Side) -->
        <div class="w-3/4 p-4 rounded-l-lg shadow-md">
            <p class="text-xl font-semibold text-gray-900 dark:text-white mb-4 ml-10">Chat Room</p>
                <div class="py-2">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="bg-gray-600 p-4 text-gray-700 dark:text-gray-100">
                                <livewire:chat-room-same-ip-component/>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</x-app-layout>
