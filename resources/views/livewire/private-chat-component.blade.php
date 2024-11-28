<div id="chatRoom" class="bg-white h-full w-full  grid grid-rows-[auto_1fr_auto] rounded-tr-2xl hidden md:grid">
    <!-- Chat Header Fixed at the Top -->
    <div class="w-full z-10 top-0">
        <livewire:chat-header-component :receiverId="$receiverId"/>
    </div>
    <!-- Messages List - Scrollable Middle Section -->
    <div class="overflow-y-auto w-full h-full">
        <livewire:message-list-component :receiverId="$receiverId" />
    </div>

    <!-- Message Input Fixed at the Bottom -->
    <div class="w-full z-10 bottom-0">
        <livewire:message-input-component :receiverId="$receiverId" :key="'message-input-'.$receiverId"/>
    </div>
</div>

