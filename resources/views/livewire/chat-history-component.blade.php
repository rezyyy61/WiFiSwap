<div class=" p-5 rounded-lg shadow-lg h-screen">
    <h1 class="mb-4 font-bold text-2xl">Chats</h1>
    <form class="flex items-center max-w-sm mx-auto bg-[#fedcdb]">
        <label for="simple-search" class="sr-only">Search</label>
        <div class="relative w-full">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 5v10M3 5a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm0 10a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm12 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm0 0V6a3 3 0 0 0-3-3H9m1.5-2-2 2 2 2" />
                </svg>
            </div>
            <input type="text" id="simple-search"
                   class="bg-[#fedcdb] text-gray-700 text-lg rounded-lg focus:ring-[rgb(42_181_125)] block w-full pl-10 pr-14 py-3 outline-none border border-[#caeddf33]"
                   placeholder="Search branch name..." required />

            <!-- Search Button -->
            <button type="submit"
                    class="absolute inset-y-0 right-0 flex items-center p-2 text-sm font-medium text-white bg-[#fedcdb] rounded-lg hover:bg-[#F7ADAA] focus:ring-4 focus:outline-none">
                <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                </svg>
                <span class="sr-only">Search</span>
            </button>
        </div>
    </form>
</div>
