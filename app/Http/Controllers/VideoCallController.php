<?php

namespace App\Http\Controllers;

use App\Models\VideoCall;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class VideoCallController extends Controller
{
    public function index()
    {
        $userType = Session::get('user_type');
        $userId = Session::get('user_id');

        if ($userType === 'vendor') {
            $videoCalls = VideoCall::where('vendor_id', $userId)->with('customer')->latest()->paginate(10);
        } else {
            $videoCalls = VideoCall::where('customer_id', $userId)->with('vendor')->latest()->paginate(10);
        }

        return view('video-calls.index', compact('videoCalls', 'userType'));
    }

    public function create()
    {
        $vendors = \App\Models\Vendor::where('is_available', true)->get();
        return view('video-calls.create', compact('vendors'));
    }

    public function store(Request $request)
    {
        $videoCall = VideoCall::create([
            'vendor_id' => $request->vendor_id,
            'customer_id' => Session::get('user_id'),
            'room_id' => 'room_' . Str::random(16),
            'status' => 'pending',
        ]);

        return redirect()->route('video-calls.join', $videoCall->id);
    }

    public function join(VideoCall $videoCall)
    {
        return view('video-calls.room', compact('videoCall'));
    }
}
