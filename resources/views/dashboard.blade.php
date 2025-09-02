@extends('layouts.app')

@section('title', 'Dashboard - VideoCall Pro')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold text-gray-900">
            Welcome back, {{ $user->name }}!
        </h1>
        <p class="text-gray-600 mt-2">
            You are logged in as a {{ ucfirst($userType) }}
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900">Total Calls</h3>
            <p class="text-3xl font-bold text-blue-600">{{ $stats['total_calls'] }}</p>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900">Completed Calls</h3>
            <p class="text-3xl font-bold text-green-600">{{ $stats['completed_calls'] }}</p>
        </div>
        
        @if($userType === 'vendor')
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900">Total Earnings</h3>
                <p class="text-3xl font-bold text-yellow-600">${{ number_format($stats['total_earnings'], 2) }}</p>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900">Active Calls</h3>
                <p class="text-3xl font-bold text-red-600">{{ $stats['active_calls'] }}</p>
            </div>
        @else
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900">Total Spent</h3>
                <p class="text-3xl font-bold text-yellow-600">${{ number_format($stats['total_spent'], 2) }}</p>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900">Pending Calls</h3>
                <p class="text-3xl font-bold text-orange-600">{{ $stats['pending_calls'] }}</p>
            </div>
        @endif
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h2>
        <div class="flex gap-4">
            @if($userType === 'customer')
                <a href="{{ route('video-calls.create') }}" 
                   class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Start New Call
                </a>
            @endif
            <a href="{{ route('video-calls.index') }}" 
               class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
                View All Calls
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Recent Calls</h2>
        </div>
        <div class="p-6">
            @if($recentCalls->count() > 0)
                <div class="space-y-4">
                    @foreach($recentCalls as $call)
                        <div class="flex justify-between items-center p-4 border rounded-lg">
                            <div>
                                <p class="font-medium">
                                    {{ $userType === 'vendor' ? $call->customer->name : $call->vendor->name }}
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
                                <a href="{{ route('video-calls.join', $call->id) }}" 
                                   class="text-blue-600 hover:text-blue-800">Join</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center">No calls found</p>
            @endif
        </div>
    </div>
</div>
@endsection
