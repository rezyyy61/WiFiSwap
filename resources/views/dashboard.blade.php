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

                    <!-- Chat Messages Container -->
                    <div id="chat-container" class="flex-1 overflow-y-auto p-6 space-y-4 bg-gray-800 h-[800px]">
                        <!-- Message 1 (Sent by user) -->
                        @foreach($messages as $message)
                            @if ($message->sender_id == Auth::id())
                                <div class="flex justify-end ">
                                    <div class="bg-blue-500 text-white p-4 rounded-lg max-w-xs shadow-lg">
                                    <p>{{ $message->message }}</p>
                                        <span
                                            class="text-xs text-gray-300 block mt-1"> {{ \Carbon\Carbon::parse($message->created_at)->format('H:i') }} </span>
                                    </div>
                                </div>

                            @else
                                <div class="flex items-start">
                                    <img src="https://via.placeholder.com/40" alt="User Avatar"
                                         class="w-10 h-10 rounded-full border-2 border-gray-200 mr-3">
                                    <div class="bg-gray-900 text-white p-4 rounded-lg max-w-xs shadow-lg">
                                        <p>{{ $message->message }}</p>
                                        <span
                                            class="text-xs text-white block mt-1"> {{ \Carbon\Carbon::parse($message->created_at)->format('H:i') }} </span>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <!-- Chat Input -->
                    <form class="mt-4" method="POST" action="{{ route('messages.store') }}"
                          enctype="multipart/form-data">
                        @csrf
                        <label for="chat" class="sr-only">Your message</label>
                        <div
                            class="flex items-center px-3 py-2 rounded-lg bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600">
                            <!-- File and Photo Upload Buttons -->
                            <label for="file-upload" class="cursor-pointer">
                                <input type="file" id="file-upload" name="file" class="hidden">
                                <div class="p-2 text-gray-500 rounded-lg hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                         fill="none" viewBox="0 0 20 18">
                                        <path fill="currentColor"
                                              d="M13 5.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0ZM7.565 7.423 4.5 14h11.518l-2.516-3.71L11 13 7.565 7.423Z"/>
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M18 1H2a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1Z"/>
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M13 5.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0ZM7.565 7.423 4.5 14h11.518l-2.516-3.71L11 13 7.565 7.423Z"/>
                                    </svg>
                                    <span class="sr-only">Upload file</span>
                                </div>
                            </label>
                            <label for="photo-upload" class="cursor-pointer">
                                <input type="file" id="photo-upload" name="photo" accept="image/*" class="hidden">
                                <div
                                    class="p-2 text-gray-500 rounded-lg hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                         fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M13.408 7.5h.01m-6.876 0h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM4.6 11a5.5 5.5 0 0 0 10.81 0H4.6Z"/>
                                    </svg>
                                    <span class="sr-only">Upload image</span>
                                </div>
                            </label>
                            <textarea name="message" id="chat" rows="1"
                                      class="block mx-4 p-2.5 w-full text-sm text-gray-900 bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                      placeholder="Your message..."></textarea>
                            <button type="submit"
                                    class="inline-flex justify-center p-2 text-blue-600 rounded-full cursor-pointer hover:bg-blue-100 dark:text-blue-500 dark:hover:bg-gray-600">
                                <svg class="w-5 h-5 rotate-90 rtl:-rotate-90" aria-hidden="true"
                                     xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                                    <path
                                        d="m17.914 18.594-8-18a1 1 0 0 0-1.828 0l-8 18a1 1 0 0 0 1.157 1.376L8 18.281V9a1 1 0 0 1 2 0v9.281l6.758 1.689a1 1 0 0 0 1.156-1.376Z"/>
                                </svg>
                                <span class="sr-only">Send message</span>
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>
