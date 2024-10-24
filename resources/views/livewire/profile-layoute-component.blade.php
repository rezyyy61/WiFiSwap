<div class="flex flex-col md:flex-row bg-white w-full gap  text-gray-800 h-screen">
    <aside class="w-full md:w-1/4 py-6">
        <div class="sticky flex flex-col gap-4 p-6 text-sm border-r border-gray-200 top-16">
            <h2 class="pl-3 mb-6 text-3xl font-bold">Settings</h2>

            <a
                wire:click="showPubicProfile"
                href="#" class="flex items-center px-4 py-3 font-semibold bg-[#CAEDDF] text-gray-700 border border-[#2AB57D] rounded-lg hover:bg-[#d7f2e8]">
                Public Profile
            </a>
            <a href="#" wire:click="showAccountSettings"
               class="flex items-center px-4 py-3 font-semibold text-gray-700 border border-transparent rounded-lg hover:text-indigo-900 hover:bg-indigo-100 hover:border-indigo-300">
                Account Settings
            </a>
            <a href="#"
               class="flex items-center px-4 py-3 font-semibold text-gray-700 border border-transparent rounded-lg hover:text-indigo-900 hover:bg-indigo-100 hover:border-indigo-300">
                Notifications
            </a>
            <a href="#"
               class="flex items-center px-4 py-3 font-semibold text-gray-700 border border-transparent rounded-lg hover:text-indigo-900 hover:bg-indigo-100 hover:border-indigo-300">
                PRO Account
            </a>
            <a href="#"
               class="flex items-center px-4 py-3 font-semibold text-gray-700 border border-transparent rounded-lg hover:text-indigo-900 hover:bg-indigo-100 hover:border-indigo-300">
                Phone Number
            </a>
            <a href="#"
               class="flex items-center px-4 py-3 font-semibold text-gray-700 border border-transparent rounded-lg hover:text-indigo-900 hover:bg-indigo-100 hover:border-indigo-300">
                Background Color
            </a>
        </div>
    </aside>
    <main class="w-full md:w-3/4 min-h-screen py-6">
        @if($currentProfile === 'PublicProfile')
            <livewire:Profile/>
        @elseif($currentProfile = 'AccountSettings')
            <livewire:Notification/>
        @endif
    </main>
</div>
