<?php

namespace Database\Seeders;

use App\Models\VideoCall;
use App\Models\CallLog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class VideoCallSeeder extends Seeder
{
    public function run(): void
    {
        $vendors = \App\Models\Vendor::all();
        $customers = \App\Models\Customer::all();

        if ($vendors->isEmpty() || $customers->isEmpty()) {
            return;
        }

        // Create some sample video calls
        for ($i = 0; $i < 15; $i++) {
            $vendor = $vendors->random();
            $customer = $customers->random();
            $status = ['pending', 'active', 'completed', 'cancelled'][array_rand(['pending', 'active', 'completed', 'cancelled'])];
            
            $startedAt = null;
            $endedAt = null;
            $durationMinutes = null;
            $totalCost = null;

            if ($status === 'active' || $status === 'completed') {
                $startedAt = now()->subMinutes(rand(10, 120));
                
                if ($status === 'completed') {
                    $durationMinutes = rand(15, 90);
                    $endedAt = $startedAt->copy()->addMinutes($durationMinutes);
                    $totalCost = ($durationMinutes / 60) * $vendor->hourly_rate;
                }
            }

            $videoCall = VideoCall::create([
                'vendor_id' => $vendor->id,
                'customer_id' => $customer->id,
                'room_id' => 'room_' . Str::random(16),
                'status' => $status,
                'started_at' => $startedAt,
                'ended_at' => $endedAt,
                'duration_minutes' => $durationMinutes,
                'total_cost' => $totalCost,
                'notes' => $status === 'completed' ? 'Call completed successfully' : null,
            ]);

            // Create some call logs for completed calls
            if ($status === 'completed' && $startedAt && $endedAt) {
                CallLog::create([
                    'video_call_id' => $videoCall->id,
                    'action' => 'call_started',
                    'user_type' => 'vendor',
                    'user_id' => $vendor->id,
                    'timestamp' => $startedAt,
                ]);

                CallLog::create([
                    'video_call_id' => $videoCall->id,
                    'action' => 'joined',
                    'user_type' => 'customer',
                    'user_id' => $customer->id,
                    'timestamp' => $startedAt->copy()->addSeconds(rand(5, 30)),
                ]);

                CallLog::create([
                    'video_call_id' => $videoCall->id,
                    'action' => 'call_ended',
                    'user_type' => 'vendor',
                    'user_id' => $vendor->id,
                    'timestamp' => $endedAt,
                ]);
            }
        }
    }
}
