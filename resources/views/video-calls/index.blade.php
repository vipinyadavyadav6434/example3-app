@extends('layouts.app')

@section('title', 'Video Calls - VideoCall Pro')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">Video Calls</h1>
        @if($userType === 'customer')
            <a href="{{ route('video-calls.create') }}" 
               class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Start New Call
            </a>
        @endif
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">All Calls</h2>
        </div>
        <div class="p-6">
            @if($videoCalls->count() > 0)
                <div class="space-y-4">
                    @foreach($videoCalls as $call)
                        <div class="flex justify-between items-center p-4 border rounded-lg">
                            <div>
                                <p class="font-medium">
                                    {{ $userType === 'vendor' ? $call->customer->name : $call->vendor->name }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    {{ $userType === 'vendor' ? $call->customer->email : $call->vendor->email }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    {{ $call->created_at->format('M d, Y H:i') }}
                                </p>
                            </div>
                            <div class="flex items-center gap-4">
                                <span class="px-2 py-1 text-xs rounded-full 
                                    {{ $call->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                       ($call->status === 'active' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800') }}">
                                    {{ ucfirst($call->status) }}
                                </span>
                                @if($call->status === 'pending' || $call->status === 'active')
                                    <a href="{{ route('video-calls.join', $call->id) }}" 
                                       class="text-blue-600 hover:text-blue-800">Join</a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-6">
                    {{ $videoCalls->links() }}
                </div>
            @else
                <p class="text-gray-500 text-center">No calls found</p>
            @endif
        </div>
    </div>
</div>
@endsection
