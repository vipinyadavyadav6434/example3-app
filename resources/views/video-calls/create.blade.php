@extends('layouts.app')

@section('title', 'Start New Call - VideoCall Pro')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Start New Video Call</h1>
        
        <form action="{{ route('video-calls.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="vendor_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Select Vendor
                    </label>
                    <select name="vendor_id" id="vendor_id" required 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Choose a vendor...</option>
                        @foreach($vendors as $vendor)
                            <option value="{{ $vendor->id }}" {{ old('vendor_id') == $vendor->id ? 'selected' : '' }}>
                                {{ $vendor->name }} - {{ $vendor->specialization }} (${{ $vendor->hourly_rate }}/hr)
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="flex gap-4">
                    <button type="submit" 
                            class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Start Call
                    </button>
                    <a href="{{ route('video-calls.index') }}" 
                       class="flex-1 px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 text-center">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
