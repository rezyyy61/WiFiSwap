<x-app-layout>
    {{--    <div class="flex p-8 space-x-4">--}}
    {{--        <!-- Left Side -->--}}
    {{--        <div class="w-1/4 p-4 rounded-l-lg shadow-md ">--}}
    {{--            <div class="bg-gray-600 p-4 text-gray-700 dark:text-gray-100">--}}
    {{--                <p class="text-xl font-semibold text-gray-900 dark:text-white mb-4 ml-5 border-amber-50">Online Users</p>--}}
    {{--                <livewire:online-users-component/>--}}
    {{--            </div>--}}

    {{--        </div>--}}

    {{--        <!-- Main Content (Right Side) -->--}}
    {{--        <div class="w-2/4 p-4 rounded-l-lg shadow-md ">--}}
    {{--            <div class="bg-gray-600 p-4 text-gray-700 dark:text-gray-100">--}}
    {{--            <p class="text-xl font-semibold text-gray-900 dark:text-white mb-4 ml-10">Chat Room</p>--}}
    {{--                <div class="py-2">--}}
    {{--                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">--}}
    {{--                        <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">--}}
    {{--                            <div class="bg-gray-600 p-4 text-gray-700 dark:text-gray-100">--}}
    {{--                                <livewire:chat-room-same-ip-component/>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--        <div class="w-1/4 p-4 rounded-l-lg shadow-md">--}}
    {{--            <div class="bg-gray-600 p-4 text-gray-700 dark:text-gray-100">--}}
    {{--                <p class="text-xl font-semibold text-gray-900 dark:text-white mb-4 ml-5 border-amber-50">Chat Rooms</p>--}}
    {{--                <livewire:chat-rooms/>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}


    <div class="container mx-auto shadow-lg rounded-lg mt-10">
        <!-- headaer -->
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
        <!-- Chatting -->
        <div class="flex flex-row justify-between bg-white">
            <!-- chat list -->
            <div class="flex flex-col w-2/5 border-r-2 overflow-y-auto">
                <!-- search compt -->
                <div class="border-b-2 py-4 px-2">
                    <input
                        type="text"
                        placeholder="search chatting"
                        class="py-2 px-2 border-2 border-gray-200 rounded-2xl w-full"
                    />
                </div>
                <!-- online user list -->
                <livewire:online-users-component/>
                <!-- end user list -->
            </div>

            <!-- message -->
            <div class="w-full px-5 flex flex-col justify-between">
                <livewire:chat-room-same-ip-component/>
            </div>
            <!-- end message -->


            <div class="w-2/5 border-l-2 px-5">
                <div class="flex flex-col">
                    <div class="font-semibold text-xl py-4">Groups</div>
                    <livewire:chat-rooms/>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
