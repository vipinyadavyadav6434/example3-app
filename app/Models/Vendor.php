<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'specialization',
        'description',
        'profile_image',
        'is_online',
        'is_available',
        'hourly_rate',
        'timezone',
        'working_hours',
    ];

    protected $casts = [
        'is_online' => 'boolean',
        'is_available' => 'boolean',
        'hourly_rate' => 'decimal:2',
        'working_hours' => 'array',
    ];

    public function videoCalls(): HasMany
    {
        return $this->hasMany(VideoCall::class);
    }

    public function getActiveCallsAttribute()
    {
        return $this->videoCalls()->where('status', 'active')->count();
    }

    public function getTotalEarningsAttribute()
    {
        return $this->videoCalls()->where('status', 'completed')->sum('total_cost');
    }

    public function getAverageRatingAttribute()
    {
        return $this->videoCalls()->where('status', 'completed')->avg('rating') ?? 0;
    }
}
