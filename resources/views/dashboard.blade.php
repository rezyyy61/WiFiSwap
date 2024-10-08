<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="bg-gray-600 p-6 text-gray-700 dark:text-gray-100">
                    <!-- Chat Header -->
                    <div
                        class="bg-gradient-to-r from-gray-800 to-teal-500 text-white py-4 px-6 flex items-center justify-between shadow-md">
                        <div class="flex items-center space-x-3">
                            <img src="https://via.placeholder.com/40" alt="User Avatar"
                                 class="w-10 h-10 rounded-full border-2 border-white">
                            <div>
                                <div class="text-xl font-semibold px-2">Chat Room</div>
                                <div class="text-sm"></div>
                            </div>
                        </div>
                        <button class="bg-blue-700 hover:bg-blue-800 text-white px-3 py-1 rounded-full text-sm">
                            Settings
                        </button>
                    </div>
{{--                    <livewire:chat-room-same-ip-component/>--}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

