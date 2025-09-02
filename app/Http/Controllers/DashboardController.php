<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Vendor;
use App\Models\VideoCall;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index()
    {
        $userType = Session::get('user_type');
        $userId = Session::get('user_id');

        if (!$userType || !$userId) {
            return redirect()->route('login');
        }

        if ($userType === 'vendor') {
            $user = Vendor::findOrFail($userId);
            $recentCalls = $user->videoCalls()->with('customer')->latest()->take(5)->get();
            $stats = [
                'total_calls' => $user->videoCalls()->count(),
                'completed_calls' => $user->videoCalls()->where('status', 'completed')->count(),
                'total_earnings' => $user->videoCalls()->where('status', 'completed')->sum('total_cost'),
                'active_calls' => $user->videoCalls()->where('status', 'active')->count(),
            ];
        } else {
            $user = Customer::findOrFail($userId);
            $recentCalls = $user->videoCalls()->with('vendor')->latest()->take(5)->get();
            $stats = [
                'total_calls' => $user->videoCalls()->count(),
                'completed_calls' => $user->videoCalls()->where('status', 'completed')->count(),
                'total_spent' => $user->videoCalls()->where('status', 'completed')->sum('total_cost'),
                'pending_calls' => $user->videoCalls()->where('status', 'pending')->count(),
            ];
        }

        return view('dashboard', compact('user', 'userType', 'recentCalls', 'stats'));
    }
}
