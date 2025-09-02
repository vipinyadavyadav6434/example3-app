<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Vendor;
use App\Models\VideoCall;
use App\Models\CallLog;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_vendors' => Vendor::count(),
            'total_customers' => Customer::count(),
            'total_calls' => VideoCall::count(),
            'active_calls' => VideoCall::where('status', 'active')->count(),
            'completed_calls' => VideoCall::where('status', 'completed')->count(),
            'total_revenue' => VideoCall::where('status', 'completed')->sum('total_cost'),
            'online_vendors' => Vendor::where('is_online', true)->count(),
            'online_customers' => Customer::where('is_online', true)->count(),
        ];

        $recentCalls = VideoCall::with(['vendor', 'customer'])
            ->latest()
            ->take(10)
            ->get();

        $topVendors = Vendor::withCount('videoCalls')
            ->orderBy('video_calls_count', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentCalls', 'topVendors'));
    }

    public function vendors()
    {
        $vendors = Vendor::withCount('videoCalls')
            ->withSum('videoCalls as total_earnings', 'total_cost')
            ->latest()
            ->paginate(15);

        return view('admin.vendors', compact('vendors'));
    }

    public function customers()
    {
        $customers = Customer::withCount('videoCalls')
            ->withSum('videoCalls as total_spent', 'total_cost')
            ->latest()
            ->paginate(15);

        return view('admin.customers', compact('customers'));
    }

    public function videoCalls()
    {
        $videoCalls = VideoCall::with(['vendor', 'customer'])
            ->latest()
            ->paginate(15);

        return view('admin.video-calls', compact('videoCalls'));
    }

    public function callLogs()
    {
        $callLogs = CallLog::with(['videoCall.vendor', 'videoCall.customer'])
            ->latest()
            ->paginate(20);

        return view('admin.call-logs', compact('callLogs'));
    }

    public function vendorDetails(Vendor $vendor)
    {
        $vendor->load(['videoCalls.customer']);
        $callStats = [
            'total_calls' => $vendor->videoCalls()->count(),
            'completed_calls' => $vendor->videoCalls()->where('status', 'completed')->count(),
            'total_earnings' => $vendor->videoCalls()->where('status', 'completed')->sum('total_cost'),
            'average_duration' => $vendor->videoCalls()->where('status', 'completed')->avg('duration_minutes'),
        ];

        return view('admin.vendor-details', compact('vendor', 'callStats'));
    }

    public function customerDetails(Customer $customer)
    {
        $customer->load(['videoCalls.vendor']);
        $callStats = [
            'total_calls' => $customer->videoCalls()->count(),
            'completed_calls' => $customer->videoCalls()->where('status', 'completed')->count(),
            'total_spent' => $customer->videoCalls()->where('status', 'completed')->sum('total_cost'),
            'average_duration' => $customer->videoCalls()->where('status', 'completed')->avg('duration_minutes'),
        ];

        return view('admin.customer-details', compact('customer', 'callStats'));
    }
}
