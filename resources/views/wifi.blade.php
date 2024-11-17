<x-app-layout>
{{--    <div class="container mx-auto shadow-lg rounded-lg mt-10">--}}
{{--        <!-- header -->--}}
{{--        <div class="px-5 py-5 flex justify-between items-center bg-white border-b-2">--}}
{{--            <div class="font-semibold text-2xl">GoingChat</div>--}}
{{--            <div class="w-1/2">--}}
{{--                <input--}}
{{--                    type="text"--}}
{{--                    name=""--}}
{{--                    id=""--}}
{{--                    placeholder="search IRL"--}}
{{--                    class="rounded-2xl bg-gray-100 py-3 px-5 w-full"--}}
{{--                />--}}
{{--            </div>--}}
{{--            <div--}}
{{--                class="h-12 w-12 p-2 bg-yellow-500 rounded-full text-white font-semibold flex items-center justify-center"--}}
{{--            >--}}
{{--                RA--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <!-- Chatting Section -->--}}
{{--        <div class="flex flex-row justify-between bg-white">--}}

{{--            <!-- Sidebar: Online Users -->--}}
{{--            <div class="flex flex-col w-max[200] border-r-2 overflow-y-auto">--}}

{{--                <!-- Online Users Heading -->--}}
{{--                <div class="border-b-2 py-4 px-2">--}}
{{--                    <h2 class="text-xl font-semibold text-gray-700 flex items-center space-x-2">--}}
{{--                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">--}}
{{--                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />--}}
{{--                        </svg>--}}
{{--                        <span>Online Users</span>--}}
{{--                    </h2>--}}
{{--                </div>--}}

{{--                <!-- Search for Users -->--}}
{{--                <div class="border-b-2 py-4 px-2">--}}
{{--                    <input--}}
{{--                        type="text"--}}
{{--                        placeholder="Search users"--}}
{{--                        class="py-2 px-2 border-2 border-gray-200 rounded-2xl w-full"--}}
{{--                    />--}}
{{--                </div>--}}

{{--                <!-- Online Users List -->--}}
{{--                <livewire:online-users-component/>--}}
{{--            </div>--}}

{{--            <!-- Chat Room -->--}}
{{--                <livewire:chat-room-same-ip-component/>--}}

{{--        </div>--}}
{{--    </div>--}}



    <div id="voice-recorder">
        <button id="start-record-btn">Start Recording</button>
        <button id="stop-record-btn" disabled>Stop Recording</button>
        <audio id="audio-playback" controls></audio>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let mediaRecorder;
        let recordedChunks = [];

        const startButton = document.getElementById('start-record-btn');
        const stopButton = document.getElementById('stop-record-btn');
        const audioPlayback = document.getElementById('audio-playback');

        // Start Recording Button
        startButton.addEventListener('click', async () => {
            console.log('Start Recording button clicked');
            try {
                recordedChunks = [];
                const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                mediaRecorder = new MediaRecorder(stream);

                mediaRecorder.start();
                console.log('MediaRecorder started');

                mediaRecorder.ondataavailable = (e) => {
                    if (e.data.size > 0) {
                        recordedChunks.push(e.data);
                    }
                };

                mediaRecorder.onstop = () => {
                    const blob = new Blob(recordedChunks, { type: 'audio/webm' });
                    const url = URL.createObjectURL(blob);
                    audioPlayback.src = url;

                    // Send the blob to the server
                    uploadAudio(blob);
                };

                stopButton.disabled = false;
                startButton.disabled = true;
            } catch (error) {
                console.error('Error accessing microphone:', error);
                alert('Could not access microphone. Please check your browser settings.');
            }
        });

        // Stop Recording Button
        stopButton.addEventListener('click', () => {
            console.log('Stop Recording button clicked');
            mediaRecorder.stop();
            stopButton.disabled = true;
            startButton.disabled = false;
        });

        // Function to upload audio blob to Livewire
        function uploadAudio(blob) {
            const file = new File([blob], 'voice-message.webm', { type: 'audio/webm' });

            // Get the Livewire component instance
            const livewireComponentElement = document.getElementById('voice-message-component');
            if (!livewireComponentElement) {
                console.error('Livewire component element not found');
                return;
            }

            const livewireComponent = Livewire.find(livewireComponentElement.getAttribute('wire:id'));
            if (!livewireComponent) {
                console.error('Livewire component instance not found');
                return;
            }

            // Upload the file to the 'audio' property of the Livewire component
            livewireComponent.upload('audio', file, (uploadedFilename) => {
                // Success callback
                console.log('Audio uploaded successfully');

                // Call the save method on the Livewire component
                livewireComponent.call('save');
            }, (error) => {
                // Error callback
                console.error('Upload error:', error);
            });
        }
    });

</script>
