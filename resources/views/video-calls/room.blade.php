@extends('layouts.app')

@section('title', 'Video Call Room - VideoCall Pro')

@section('content')
<div class="min-h-screen bg-gray-900">
    <div class="flex flex-col h-screen">
        <!-- Header -->
        <div class="bg-gray-800 text-white p-4">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-xl font-bold">Video Call</h1>
                    <p class="text-gray-300">Room: {{ $videoCall->room_id }}</p>
                </div>
                <div class="flex items-center gap-4">
                    <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                        {{ ucfirst($videoCall->status) }}
                    </span>
                    <a href="{{ route('video-calls.index') }}" 
                       class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                        End Call
                    </a>
                </div>
            </div>
        </div>

        <!-- Video Container -->
        <div class="flex-1 flex">
            <div class="flex-1 p-4">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 h-full">
                    <!-- Local Video -->
                    <div class="bg-gray-800 rounded-lg overflow-hidden relative">
                        <video id="localVideo" autoplay muted playsinline 
                               class="w-full h-full object-cover"></video>
                        <div class="absolute bottom-4 left-4 text-white text-sm">
                            You (Local)
                        </div>
                    </div>
                    
                    <!-- Remote Video -->
                    <div class="bg-gray-800 rounded-lg overflow-hidden relative">
                        <video id="remoteVideo" autoplay playsinline 
                               class="w-full h-full object-cover"></video>
                        <div class="absolute bottom-4 left-4 text-white text-sm">
                            Remote User
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Controls -->
        <div class="bg-gray-800 p-4">
            <div class="flex justify-center items-center gap-4">
                <button id="toggleVideo" class="p-3 bg-gray-700 text-white rounded-full hover:bg-gray-600">
                    Video
                </button>
                
                <button id="toggleAudio" class="p-3 bg-gray-700 text-white rounded-full hover:bg-gray-600">
                    Audio
                </button>
                
                <button id="toggleScreen" class="p-3 bg-gray-700 text-white rounded-full hover:bg-gray-600">
                    Screen
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Simple WebRTC implementation
async function initializeVideo() {
    try {
        const stream = await navigator.mediaDevices.getUserMedia({
            video: true,
            audio: true
        });
        
        document.getElementById('localVideo').srcObject = stream;
        console.log('Video initialized');
    } catch (error) {
        console.error('Error accessing media devices:', error);
        alert('Please allow camera and microphone access');
    }
}

// Initialize when page loads
document.addEventListener('DOMContentLoaded', initializeVideo);
</script>
@endsection
