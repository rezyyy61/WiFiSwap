<div class="p-4 md:p-8 bg-white shadow-md rounded-lg h-screen">
    <div class="w-full px-8 pb-10">
        <h2 class="text-3xl font-bold text-gray-800">Public Profile</h2>

        <div class="grid max-w-2xl mx-auto mt-10">
            <div class="flex flex-col items-center space-y-6 sm:flex-row sm:space-y-0 sm:space-x-8">

                <img class="object-cover w-40 h-40 p-1 rounded-full ring-4 ring-[#2AB57D]"
                     src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTB8fGZhY2V8ZW58MHx8MHx8fDA%3D&auto=format&fit=crop&w=500&q=60"
                     alt="Bordered avatar">

                <div class="flex flex-col space-y-4">
                    <button type="button"
                            class="py-3 px-6 text-base font-medium text-white bg-[#2AB57D] rounded-lg border   focus:outline-none focus:ring-1">
                        Change picture
                    </button>
                    <button type="button"
                            class="py-3 px-6 text-base font-medium text-gray-800 bg-white rounded-lg border border-gray-300 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-indigo-200">
                        Delete picture
                    </button>
                </div>
            </div>

            <div class="items-center mt-12 text-gray-800">

                <div class="flex flex-col sm:flex-row sm:space-x-6">
                    <div class="w-full mb-6 sm:mb-8">
                        <label for="first_name"
                               class="block mb-2 text-sm font-medium text-gray-700">First Name</label>
                        <input type="text" id="first_name"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-3"
                               placeholder="Your first name" value="" required>
                    </div>

                    <div class="w-full mb-6 sm:mb-8">
                        <label for="last_name"
                               class="block mb-2 text-sm font-medium text-gray-700">Account Id</label>
                        <input type="text" id="last_name"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-3"
                               placeholder="Set Account Id" value="" required>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="email"
                           class="block mb-2 text-sm font-medium text-gray-700">Email Address</label>
                    <input type="email" id="email"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-3"
                           placeholder="your.email@mail.com" value="" required>
                </div>

                <div class="mb-6">
                    <label for="phone"
                           class="block mb-2 text-sm font-medium text-gray-700">Phone Number</label>
                    <input type="text" id="phone"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-3"
                           placeholder="Your phone number" value="">
                </div>

                <div class="mb-6">
                    <label for="background_color"
                           class="block mb-2 text-sm font-medium text-gray-700">Background Color</label>
                    <input type="text" id="background_color"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-3"
                           placeholder="Preferred background color" value="">
                </div>

                <div class="mb-8">
                    <label for="message"
                           class="block mb-2 text-sm font-medium text-gray-700">Bio</label>
                    <textarea id="message" rows="4"
                              class="block w-full p-3 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
                              placeholder="Write your bio here..."></textarea>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                            class="text-white bg-[#2AB57D]  focus:ring-1 focus:outline-none  font-medium rounded-lg text-sm px-6 py-3">
                        Save Changes
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>
