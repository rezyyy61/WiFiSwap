<div id="Container" class="flex flex-col w-full p-4 bg-gray-100 rounded-lg space-y-4">
    <form wire:submit.prevent="sendMessage" class="flex flex-col w-full space-y-4">
        <!-- Hidden Inputs -->
        <input type="hidden" id="audio_data" wire:model="audioData"/>
        <input type="hidden" id="audio_duration" wire:model="audioDuration"/>
        <!-- File/Image Upload Button -->
        <div class="flex items-center space-x-2">
            <!-- Sticker Button -->
            <button type="button"
                    class="p-2 text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z"/>
                    <path
                        d="M16.5 10.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zm-6 0a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM12 14.75c1.5 0 4 0.75 4 2.25H8c0-1.5 2.5-2.25 4-2.25z"
                        fill="#000"/>
                </svg>
            </button>

            <!-- File Upload Button -->
            <label
                class="p-2 text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer">
                <input
                    wire:model="uploadedFile"
                    type="file"
                    class="hidden"
                    accept="image/*, .pdf, .doc, .docx"/>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m7-7H5"/>
                </svg>
            </label>

            <!-- Voice Recording Button -->
            <button
                id="voice_btn" @click="toggleRecording()"
                type="button"
                class="p-2 text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 {{ $isRecording ? 'focus:ring-red-500' : 'focus:ring-blue-500' }}"
            >
                @if($isRecording)
                    <!-- Stop Recording Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-600 bg-white" viewBox="0 0 24 24"
                         fill="currentColor">
                        <path d="M6 6h12v12H6V6z"/>
                    </svg>
                @else
                    <!-- Start Recording Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-600 bg-white" viewBox="0 0 24 24"
                         fill="currentColor">
                        <path
                            d="M12 3a3 3 0 00-3 3v6a3 3 0 106 0V6a3 3 0 00-3-3zM7 11.25V12c0 2.76 2.24 5 5 5s5-2.24 5-5v-.75M8.5 19h7m-7-1v1m7-1v1"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                @endif
            </button>
        </div>

        <!-- File Preview Section -->
        @if ($uploadedFile)
            <div class="p-4 bg-white border border-gray-300 rounded-lg w-full h-full">
                @if (str_starts_with($uploadedFile->getMimeType(), 'image/'))
                    <!-- Large Image Preview -->
                    <div class="flex flex-col items-center space-y-2">
                        <img src="{{ $uploadedFile->temporaryUrl() }}" alt="Preview"
                             class="w-1/2 max-h-[450px] rounded-md shadow-md">
                        <p class="text-sm text-gray-600">File Name: {{ $uploadedFile->getClientOriginalName() }}</p>
                        <p class="text-xs text-gray-500">Size: {{ number_format($uploadedFile->getSize() / 1024, 2) }}
                            KB</p>
                    </div>
                @else
                    <!-- File Preview with Icon -->
                    <div class="flex flex-col items-center space-y-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-gray-500" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 2v6h6"/>
                        </svg>
                        <p class="text-sm font-semibold text-gray-700">{{ $uploadedFile->getClientOriginalName() }}</p>
                        <p class="text-xs text-gray-500">Size: {{ number_format($uploadedFile->getSize() / 1024, 2) }}
                            KB</p>
                    </div>
                @endif

                <!-- File Description Input -->
                <textarea
                    wire:model.defer="fileDescription"
                    rows="3"
                    class="w-full p-2 mt-4 text-sm text-gray-700 bg-gray-50 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                    placeholder="Add a description for the file..."></textarea>

                <!-- Remove File Button -->
                <button type="button" wire:click="$set('uploadedFile', null)"
                        class="mt-2 text-red-500 hover:text-red-600">
                    Remove File
                </button>
            </div>
        @endif


        <!-- Text Input and Send Button -->
        <div class="flex items-center w-full space-x-2">
            <!-- Input or Audio Playback Container -->
            <div id="inputOrPlayback" class="flex-1 m-auto" wire:ignore.self>
                <!-- Initially, it contains the input field -->
                <input
                    id="messageInput"
                    wire:model.live="message"
                    type="text"
                    name="message"
                    placeholder="Enter Message..."
                    wire:keydown.enter="sendMessage"
                    class="w-full p-2 text-gray-700 bg-white border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                />
            </div>
            <button
                id="send_btn"
                type="submit"
                class="p-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7-7 7M5 12h16"/>
                </svg>
            </button>
        </div>
    </form>
</div>

@script
<script>
    const voiceBtn = document.querySelector('#voice_btn');
    const sendBtn = document.querySelector('#send_btn');
    const inputOrPlayback = document.querySelector('#inputOrPlayback');
    const form = document.querySelector('form');

    let can_record = false;
    let is_recording = false;
    let recorder = null;
    let chunks = [];
    let audioURL = null;

    let recordingTimer = null;
    let recordingStartTime = null;

    function setupAudio() {
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices
                .getUserMedia({ audio: true })
                .then(setupStream)
                .catch(err => console.error('Error accessing microphone:', err));
        } else {
            console.error('getUserMedia not supported on your browser!');
        }
    }

    function setupStream(stream) {
        recorder = new MediaRecorder(stream);

        recorder.ondataavailable = e => {
            chunks.push(e.data);
        };

        recorder.onstop = ev => {
            stopRecordingIndicator();
            const blob = new Blob(chunks, { type: "audio/ogg; codecs=opus" });
            chunks = [];

            // Create an audio URL
            audioURL = URL.createObjectURL(blob);

            // Replace input field with audio playback
            displayAudioPlayback(audioURL);

            // Read the blob as a data URL (base64)
            const reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onloadend = function() {
                const base64data = reader.result.split(',')[1];

                // Set the base64 data to the hidden input
                const dataInput = document.querySelector('#audio_data');
                if (dataInput) {
                    dataInput.value = base64data;

                    // Manually trigger Livewire input change event
                    const event = new Event('input', { bubbles: true });
                    dataInput.dispatchEvent(event);
                }
            };
        };

        can_record = true;
    }

    function toggleMic() {
        if (!can_record) return;
        is_recording = !is_recording;

        if (is_recording) {
            recorder.start();
            console.log('Recording started');
            voiceBtn.classList.add('recording');
            startRecordingIndicator();
        } else {
            recorder.stop();
            console.log('Recording stopped');
            voiceBtn.classList.remove('recording');
        }
    }

    function startRecordingIndicator() {
        recordingStartTime = Date.now();

        // Remove the input field
        const messageInput = document.querySelector('#messageInput');
        if (messageInput) {
            messageInput.remove();
        }

        // Create a container for the recording indicator
        const recordingIndicator = document.createElement('div');
        recordingIndicator.id = 'recordingIndicator';
        recordingIndicator.classList.add('flex', 'items-center', 'space-x-2');

        // Create a red dot
        const redDot = document.createElement('div');
        redDot.classList.add('w-3', 'h-3', 'bg-red-600', 'rounded-full', 'animate-pulse');

        // Create a timer display
        const timerDisplay = document.createElement('span');
        timerDisplay.id = 'timerDisplay';
        timerDisplay.classList.add('text-gray-700', 'font-semibold');
        timerDisplay.textContent = '00:00';

        // Append the red dot and timer to the recording indicator
        recordingIndicator.appendChild(redDot);
        recordingIndicator.appendChild(timerDisplay);

        // Add the recording indicator to the inputOrPlayback div
        inputOrPlayback.appendChild(recordingIndicator);

        // Start the timer
        recordingTimer = setInterval(updateRecordingTimer, 1000);
    }

    function updateRecordingTimer() {
        const timerDisplay = document.querySelector('#timerDisplay');
        if (timerDisplay) {
            const elapsed = Math.floor((Date.now() - recordingStartTime) / 1000);
            const minutes = String(Math.floor(elapsed / 60)).padStart(2, '0');
            const seconds = String(elapsed % 60).padStart(2, '0');
            timerDisplay.textContent = `${minutes}:${seconds}`;
        }
    }

    function stopRecordingIndicator() {
        // Stop the timer
        clearInterval(recordingTimer);
        recordingTimer = null;

        // Calculate the duration in seconds
        const elapsedSeconds = Math.floor((Date.now() - recordingStartTime) / 1000);
        recordingStartTime = null;

        // Remove the recording indicator
        const recordingIndicator = document.querySelector('#recordingIndicator');
        if (recordingIndicator) {
            recordingIndicator.remove();
        }

        // Set the duration in the hidden input
        const durationInput = document.querySelector('#audio_duration');
        if (durationInput) {
            durationInput.value = elapsedSeconds;
            // Manually trigger Livewire input change event
            const event = new Event('input', { bubbles: true });
            durationInput.dispatchEvent(event);
        }
    }


    function displayAudioPlayback(url) {
        // Create a container for audio playback and controls
        const playbackContainer = document.createElement('div');
        playbackContainer.id = 'playbackContainer';
        playbackContainer.classList.add('flex', 'items-center', 'space-x-2');

        // Create an audio element
        const audio = document.createElement('audio');
        audio.id = 'audioPlayback';
        audio.controls = true;
        audio.src = url;

        // Create a delete button to cancel the audio message
        const deleteBtn = document.createElement('button');
        deleteBtn.type = 'button';
        deleteBtn.classList.add('p-2', 'text-gray-600', 'bg-white', 'border', 'border-gray-300', 'rounded-lg', 'hover:bg-gray-200', 'focus:outline-none', 'focus:ring-2', 'focus:ring-blue-500');
        deleteBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">' +
            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />' +
            '</svg>';

        deleteBtn.addEventListener('click', function() {
            // Remove audio playback and restore input field
            playbackContainer.remove();
            restoreInputField();
        });

        // Append audio and delete button to the playback container
        playbackContainer.appendChild(audio);
        playbackContainer.appendChild(deleteBtn);

        // Add the playback container to the inputOrPlayback div
        inputOrPlayback.appendChild(playbackContainer);
    }

    function restoreInputField() {
        // Remove the audio data from the hidden input
        const dataInput = document.querySelector('#audio_data');
        if (dataInput) {
            dataInput.value = '';
            // Manually trigger Livewire input change event
            const event = new Event('input', { bubbles: true });
            dataInput.dispatchEvent(event);
        }

        // Create a new input field
        const input = document.createElement('input');
        input.id = 'messageInput';
        input.setAttribute('wire:model.live', 'message');
        input.type = 'text';
        input.name = 'message';
        input.placeholder = 'Enter Message...';
        input.className = 'w-full p-2 text-gray-700 bg-white border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500';

        // Add the new input field to the inputOrPlayback div
        inputOrPlayback.appendChild(input);
    }

    function attachFileToLivewire(file) {
        const fileInput = document.querySelector('#audio_data');

        // Create a DataTransfer to simulate a file selection
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);

        // Set the files property of the file input
        fileInput.files = dataTransfer.files;

        // Manually trigger Livewire input change event
        const event = new Event('input', { bubbles: true });
        fileInput.dispatchEvent(event);
    }

    voiceBtn.addEventListener('click', toggleMic);
    setupAudio();
</script>
@endscript
