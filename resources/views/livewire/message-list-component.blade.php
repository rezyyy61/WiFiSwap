
@script
<script>
    let recorder, chunks = [], audioBlob, waveSurferInstance;
    let playback = document.querySelector('#playback');
    const voiceBtn = document.querySelector('#voice_btn');
    const removeVoiceBtn = document.querySelector('#removeVoice');

    // Function to set up audio recording
    function setupAudio() {
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({ audio: true })
                .then(stream => {
                    recorder = new MediaRecorder(stream);

                    // Initialize WaveSurfer
                    waveSurferInstance = WaveSurfer.create({
                        container: '#waveform',
                        waveColor: 'lightgray',
                        progressColor: 'blue',
                        height: 100,
                        responsive: true
                    });

                    // Handle audio data while recording
                    recorder.ondataavailable = function(e) {
                        chunks.push(e.data);

                        // Create a blob and send to WaveSurfer in real-time
                        const audioData = new Blob(chunks, { type: 'audio/ogg; codecs=opus' });
                        const audioURL = URL.createObjectURL(audioData);

                        // Load the new data into WaveSurfer
                        waveSurferInstance.load(audioURL);
                    };

                    // Handle stop recording
                    recorder.onstop = onRecordingStop;
                })
                .catch(err => console.error('Error accessing microphone:', err));
        } else {
            console.error('getUserMedia not supported in this browser.');
        }
    }

    // Function to toggle between recording and stopping
    function toggleRecording() {
        if (recorder && recorder.state === "inactive") {
            chunks = [];
            recorder.start();
            console.log("Recording started");
            playback.classList.remove('hidden');
        } else if (recorder && recorder.state === "recording") {
            recorder.stop();
            console.log("Recording stopped");
        }
    }

    // Function to handle the end of the recording
    function onRecordingStop() {
        audioBlob = new Blob(chunks, { type: "audio/ogg; codecs=opus" });
        const audioURL = URL.createObjectURL(audioBlob);
        waveSurferInstance.load(audioURL);
    }

    // Function to remove voice recording
    removeVoiceBtn.addEventListener('click', () => {
        playback.classList.add('hidden'); // Hide the waveform display
        waveSurferInstance.destroy();  // Destroy WaveSurfer instance to reset
        waveSurferInstance = null;
        document.querySelector('#voiceDescription').value = '';  // Clear any description
    });

    // Add event listener for the voice button to start/stop recording
    voiceBtn.addEventListener('click', toggleRecording);

    // Initialize the audio setup
    setupAudio();
</script>
@endscript






























@php use Illuminate\Support\Facades\Auth; @endphp
<div id="Container" class="flex-grow overflow-y-auto h-full p-6 w-full  bg-[#F7F9FC] rounded-lg shadow-lg">
    @foreach($messages as $message)
        @php
            $isSender = $message['sender_id'] === Auth::id();
            $messageType = $message['type'] ?? 'text';
        @endphp
            <!-- Other user's message -->
        @if(!$isSender)
            <div wire:key="message-{{ $message['id'] }}" class="flex items-start space-x-4 mb-6">
                <div
                    class="bg-[#004d66] p-5 rounded-lg max-w-full sm:max-w-1/2 md:max-w-1/2 lg:max-w-1/2 xl:max-w-1/2 text-white font-medium text-base shadow-xl flex flex-col space-y-2">
                    @if($messageType === 'text')
                        <p class="leading-relaxed text-sm break-words whitespace-pre-wrap max-w-full">{{ $message['message'] }}</p>
                    @elseif($messageType === 'voice')
                        <div x-data="voiceMessage({{ $message['id'] }}, '{{ $message['file_path'] }}')"
                             x-init="init()" class="flex items-center space-x-2">
                            <button
                                :class="{ 'bg-blue-600': isPlaying, 'bg-[#004d66] ': !isPlaying }"
                                x-on:click="togglePlayStop"
                                class="play-stop-btn p-1 rounded-full transition-transform transform hover:scale-105">

                                <!-- Play icon when not playing, Stop icon when playing -->
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     :class="{'block': !isPlaying, 'hidden': isPlaying}"
                                     class="w-4 h-4 transition-transform"
                                     xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" viewBox="0 0 256 256"
                                     xml:space="preserve">
                                            <defs></defs>
                                    <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;"
                                       transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)">
                                        <path
                                            d="M 18.841 90 c -0.755 0 -1.513 -0.171 -2.215 -0.518 c -1.706 -0.843 -2.785 -2.58 -2.785 -4.482 V 5 c 0 -1.902 1.079 -3.64 2.785 -4.482 c 1.707 -0.842 3.742 -0.645 5.252 0.51 l 52.318 40 c 1.237 0.946 1.963 2.415 1.963 3.972 s -0.726 3.026 -1.963 3.972 l -52.318 40 C 20.989 89.651 19.918 90 18.841 90 z"
                                            style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;"
                                            transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round"/>
                                    </g>
                                        </svg>
                                <svg
                                    :class="{'block': isPlaying, 'hidden': !isPlaying}"
                                    class="w-4 h-4 transition-transform"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    version="1.1" width="256" height="256" viewBox="0 0 256 256"
                                    xml:space="preserve"><defs></defs>
                                    <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;"
                                       transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)">
                                        <circle cx="45" cy="45" r="45"
                                                style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(32,196,203); fill-rule: nonzero; opacity: 1;"
                                                transform="  matrix(1 0 0 1 0 0) "/>
                                        <path
                                            d="M 64.541 73.014 H 19.342 c -1.288 0 -2.342 -1.054 -2.342 -2.342 V 25.473 c 0 -1.288 1.054 -2.342 2.342 -2.342 h 45.199 c 1.288 0 2.342 1.054 2.342 2.342 v 45.199 C 66.882 71.96 65.829 73.014 64.541 73.014 z"
                                            style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(27,167,173); fill-rule: nonzero; opacity: 1;"
                                            transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round"/>
                                        <path
                                            d="M 67.658 69.702 H 22.459 c -1.288 0 -2.342 -1.054 -2.342 -2.342 V 22.162 c 0 -1.288 1.054 -2.342 2.342 -2.342 h 45.199 c 1.288 0 2.342 1.054 2.342 2.342 v 45.199 C 70 68.649 68.946 69.702 67.658 69.702 z"
                                            style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(255,255,255); fill-rule: nonzero; opacity: 1;"
                                            transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round"/>
                                    </g>
                                        </svg>
                            </button>
                            <div id="waveform-{{ $message['id'] }}" class="w-[120px] h-[40px] rounded-lg "></div>
                        </div>
                    @elseif($messageType === 'file')
                        @php
                            $isImage = in_array(pathinfo($message['file_path'], PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']);
                        @endphp
                        @if($isImage)
                            <img src="{{ Storage::url($message['file_path']) }}"
                                 alt="Image"
                                 class="w-full h-auto max-w-xs rounded-lg shadow-md">
                        @else
                            <a href="{{ Storage::url($message['file_path']) }}"
                               download="{{ basename($message['file_path']) }}"
                               class="flex items-center gap-2 text-sm font-medium text-white dark:text-white pb-2">
                                <!-- Icon for the file -->
                                <svg fill="none" aria-hidden="true" class="w-5 h-5 flex-shrink-0" viewBox="0 0 20 21">
                                    <g clip-path="url(#clip0_3173_1381)">
                                        <path fill="#E2E5E7" d="M5.024.5c-.688 0-1.25.563-1.25 1.25v17.5c0 .688.562 1.25 1.25 1.25h12.5c.687 0 1.25-.563 1.25-1.25V5.5l-5-5h-8.75z"/>
                                        <path fill="#B0B7BD" d="M15.024 5.5h3.75l-5-5v3.75c0 .688.562 1.25 1.25 1.25z"/>
                                        <path fill="#CAD1D8" d="M18.774 9.25l-3.75-3.75h3.75v3.75z"/>
                                        <path fill="#F15642" d="M16.274 16.75a.627.627 0 01-.625.625H1.899a.627.627 0 01-.625-.625V10.5c0-.344.281-.625.625-.625h13.75c.344 0 .625.281.625.625v6.25z"/>
                                        <path fill="#fff" d="M3.998 12.342c0-.165.13-.345.34-.345h1.154c.65 0 1.235.435 1.235 1.269 0 .79-.585 1.23-1.235 1.23h-.834v.66c0 .22-.14.344-.32.344a.337.337 0 01-.34-.344v-2.814zm.66.284v1.245h.834c.335 0 .6-.295.6-.605 0-.35-.265-.64-.6-.64h-.834zM7.706 15.5c-.165 0-.345-.09-.345-.31v-2.838c0-.18.18-.31.345-.31H8.85c2.284 0 2.234 3.458.045 3.458h-1.19zm.315-2.848v2.239h.83c1.349 0 1.409-2.24 0-2.24h-.83zM11.894 13.486h1.274c.18 0 .36.18.36.355 0 .165-.18.3-.36.3h-1.274v1.049c0 .175-.124.31-.3.31-.22 0-.354-.135-.354-.31v-2.839c0-.18.135-.31.355-.31h1.754c.22 0 .35.13.35.31 0 .16-.13.34-.35.34h-1.455v.795z"/>
                                        <path fill="#CAD1D8" d="M15.649 17.375H3.774V18h11.875a.627.627 0 00.625-.625v-.625a.627.627 0 01-.625.625z"/>
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_3173_1381">
                                            <path fill="#fff" d="M0 0h20v20H0z" transform="translate(0 .5)"/>
                                        </clipPath>
                                    </defs>
                                </svg>

                                <!-- File name -->
                                <span class="break-words text-white">{{ basename($message['file_path']) }}</span>
                            </a>
                        @endif
                    @endif
                    <span class="text-xs text-gray-200 mt-2 self-end">{{ \Carbon\Carbon::parse($message['created_at'])->format('H:i') }}</span>
                </div>
            </div>
        @endif
        <!-- Current user's message -->
        @if($isSender)
            <div wire:key="message-{{ $message['id'] }}" class="flex items-start justify-end space-x-4 mb-6">
                <div
                    class="bg-gradient-to-r from-[#EFF2F7] to-[#D1D9E6] p-5 rounded-lg max-w-3xl text-black font-medium text-base shadow-xl flex flex-col space-y-2">
                    @if($messageType === 'text')
                        <p class="leading-relaxed text-sm break-words max-w-full">{{ $message['message'] }}</p>
                    @elseif($messageType === 'voice')
                        <div wire:key="message-{{ $message['id'] }}"
                             x-data="voiceMessage({{ $message['id'] }}, '{{ $message['file_path'] }}')"
                             x-init="init()" class="flex items-center space-x-4">
                            <button
                                :class="{ 'bg-blue-600': isPlaying, 'bg-gray-200': !isPlaying }"
                                x-on:click="togglePlayStop"
                                class="play-stop-btn p-1  rounded-full transition-transform transform hover:scale-105">

                                <!-- Play icon when not playing, Stop icon when playing -->

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     :class="{'block': !isPlaying, 'hidden': isPlaying}"
                                     class="w-4 h-4 transition-transform"
                                     xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"
                                     viewBox="0 0 256 256" xml:space="preserve">
                                            <defs></defs>
                                    <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;"
                                       transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)">
                                        <path
                                            d="M 18.841 90 c -0.755 0 -1.513 -0.171 -2.215 -0.518 c -1.706 -0.843 -2.785 -2.58 -2.785 -4.482 V 5 c 0 -1.902 1.079 -3.64 2.785 -4.482 c 1.707 -0.842 3.742 -0.645 5.252 0.51 l 52.318 40 c 1.237 0.946 1.963 2.415 1.963 3.972 s -0.726 3.026 -1.963 3.972 l -52.318 40 C 20.989 89.651 19.918 90 18.841 90 z"
                                            style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;"
                                            transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round"/>
                                    </g>
                                        </svg>
                                <svg
                                    :class="{'block': isPlaying, 'hidden': !isPlaying}"
                                    class="w-4 h-4 transition-transform"
                                    xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="256"
                                    height="256" viewBox="0 0 256 256" xml:space="preserve">
                                            <defs></defs>
                                    <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;"
                                       transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)">
                                        <circle cx="45" cy="45" r="45"
                                                style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(32,196,203); fill-rule: nonzero; opacity: 1;"
                                                transform="  matrix(1 0 0 1 0 0) "/>
                                        <path
                                            d="M 64.541 73.014 H 19.342 c -1.288 0 -2.342 -1.054 -2.342 -2.342 V 25.473 c 0 -1.288 1.054 -2.342 2.342 -2.342 h 45.199 c 1.288 0 2.342 1.054 2.342 2.342 v 45.199 C 66.882 71.96 65.829 73.014 64.541 73.014 z"
                                            style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(27,167,173); fill-rule: nonzero; opacity: 1;"
                                            transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round"/>
                                        <path
                                            d="M 67.658 69.702 H 22.459 c -1.288 0 -2.342 -1.054 -2.342 -2.342 V 22.162 c 0 -1.288 1.054 -2.342 2.342 -2.342 h 45.199 c 1.288 0 2.342 1.054 2.342 2.342 v 45.199 C 70 68.649 68.946 69.702 67.658 69.702 z"
                                            style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(255,255,255); fill-rule: nonzero; opacity: 1;"
                                            transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round"/>
                                    </g>
                                        </svg>
                            </button>
                            <div id="waveform-{{ $message['id'] }}"
                                 class="w-[120px] h-[40px] rounded-lg "></div>
                        </div>
                    @elseif($messageType === 'file')
                        @php
                            $isImage = in_array(pathinfo($message['file_path'], PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']);
                        @endphp
                        @if($isImage)
                            <img src="{{ Storage::url($message['file_path']) }}"
                                 alt="Image"
                                 class="w-full h-auto max-w-xs rounded-lg shadow-md">
                        @else
                            <a href="{{ Storage::url($message['file_path']) }}"
                               download="{{ basename($message['file_path']) }}"
                               class="flex items-center gap-2 text-sm font-medium text-block dark:text-white pb-2">
                                <!-- Icon for the file -->
                                <svg fill="none" aria-hidden="true" class="w-5 h-5 flex-shrink-0" viewBox="0 0 20 21">
                                    <g clip-path="url(#clip0_3173_1381)">
                                        <path fill="#E2E5E7" d="M5.024.5c-.688 0-1.25.563-1.25 1.25v17.5c0 .688.562 1.25 1.25 1.25h12.5c.687 0 1.25-.563 1.25-1.25V5.5l-5-5h-8.75z"/>
                                        <path fill="#B0B7BD" d="M15.024 5.5h3.75l-5-5v3.75c0 .688.562 1.25 1.25 1.25z"/>
                                        <path fill="#CAD1D8" d="M18.774 9.25l-3.75-3.75h3.75v3.75z"/>
                                        <path fill="#F15642" d="M16.274 16.75a.627.627 0 01-.625.625H1.899a.627.627 0 01-.625-.625V10.5c0-.344.281-.625.625-.625h13.75c.344 0 .625.281.625.625v6.25z"/>
                                        <path fill="#fff" d="M3.998 12.342c0-.165.13-.345.34-.345h1.154c.65 0 1.235.435 1.235 1.269 0 .79-.585 1.23-1.235 1.23h-.834v.66c0 .22-.14.344-.32.344a.337.337 0 01-.34-.344v-2.814zm.66.284v1.245h.834c.335 0 .6-.295.6-.605 0-.35-.265-.64-.6-.64h-.834zM7.706 15.5c-.165 0-.345-.09-.345-.31v-2.838c0-.18.18-.31.345-.31H8.85c2.284 0 2.234 3.458.045 3.458h-1.19zm.315-2.848v2.239h.83c1.349 0 1.409-2.24 0-2.24h-.83zM11.894 13.486h1.274c.18 0 .36.18.36.355 0 .165-.18.3-.36.3h-1.274v1.049c0 .175-.124.31-.3.31-.22 0-.354-.135-.354-.31v-2.839c0-.18.135-.31.355-.31h1.754c.22 0 .35.13.35.31 0 .16-.13.34-.35.34h-1.455v.795z"/>
                                        <path fill="#CAD1D8" d="M15.649 17.375H3.774V18h11.875a.627.627 0 00.625-.625v-.625a.627.627 0 01-.625.625z"/>
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_3173_1381">
                                            <path fill="#fff" d="M0 0h20v20H0z" transform="translate(0 .5)"/>
                                        </clipPath>
                                    </defs>
                                </svg>

                                <!-- File name -->
                                <span class="break-words text-black">{{ basename($message['file_path']) }}</span>
                            </a>
                        @endif
                    @endif
                    <!-- Timestamp inside the message container -->
                    <div class="flex justify-between items-center mt-2">
                                <span
                                    class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($message['created_at'])->format('H:i') }}</span>

                        <!-- Seen/Not Seen Icons -->
                        @if(isset($message['is_seen']) && !$message['is_seen'])
                            <span class="text-xs text-gray-400 ml-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-5 h-5 text-gray-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                    </svg></span>
                        @else
                            <span class="text-xs text-gray-400 ml-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-5 h-5 text-blue-600">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M9 12.75L11.25 15L15 9.75M21 12a9 9 0 11-9-9 9 9 0 019 9z"/>
                    </svg></span>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    @endforeach
    <!-- Typing Indicator for Other User -->
    @if(isset($isTyping[$receiverId]) && $isTyping[$receiverId])
        <div class="flex items-center space-x-3">
            <img src="https://via.placeholder.com/40" class="w-8 h-8 rounded-full" alt="">
            <div class="bg-[#2AB57D] p-2 rounded-lg max-w-3xl text-white font-bold px-4 animate-pulse">
                <p><em>typing...</em></p>
            </div>
        </div>
    @endif
    @if(isset($isRecording[$receiverId]) && $isRecording[$receiverId])
        <div class="recording-indicator">
            The user is recording a voice message...
        </div>
    @endif
</div>

<!-- Add your voiceMessage function script here -->
@script
<script>
    let container = document.querySelector('#Container');
    if (container) {
        setTimeout(() => {
            container.scrollTop = container.scrollHeight;
        }, 100);
    } else {
        console.log('#Container not found');
    }

    window.voiceMessage = function (messageId, filePath) {
        return {
            isPlaying: false,
            wavesurfer: null,
            isInitialized: false, // Track initialization

            togglePlayStop() {
                if (this.isPlaying) {
                    this.wavesurfer.pause();
                } else {
                    this.wavesurfer.play();
                }
                this.isPlaying = !this.isPlaying;
            },

            initWaveSurfer() {
                // Ensure WaveSurfer is initialized only once
                if (!this.isInitialized) {
                    const container = document.getElementById(`waveform-${messageId}`);
                    if (!container) {
                        console.error(`WaveSurfer container not found for messageId: ${messageId}`);
                        return;
                    }

                    this.wavesurfer = WaveSurfer.create({
                        container: container,
                        waveColor: '#6B7280',
                        progressColor: '#383351',
                        height: 50,
                        responsive: true,
                    });

                    // Adjust the file path to match your storage URL structure
                    const audioPath = `/storage/voice_messages/${filePath.split('/').pop()}`;
                    this.wavesurfer.load(audioPath);

                    this.isInitialized = true; // Mark as initialized
                }
            },

            init() {
                this.initWaveSurfer(); // Initialize WaveSurfer
            },
        };
    };

    // Reinitialize Alpine and WaveSurfer after Livewire updates
    document.addEventListener('DOMContentLoaded', () => {
        Livewire.hook('message.processed', (message, component) => {
            console.log('Livewire updated, reinitializing WaveSurfer');

            // Select all elements with voiceMessage components and reinitialize them

        });
    });
</script>
@endscript
