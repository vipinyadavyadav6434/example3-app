<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'profile_image',
        'is_online',
    ];

    protected $casts = [
        'is_online' => 'boolean',
    ];

    public function videoCalls(): HasMany
    {
        return $this->hasMany(VideoCall::class);
    }

    public function getTotalCallsAttribute()
    {
        return $this->videoCalls()->count();
    }

    public function getCompletedCallsAttribute()
    {
        return $this->videoCalls()->where('status', 'completed')->count();
    }

    public function getTotalSpentAttribute()
    {
        return $this->videoCalls()->where('status', 'completed')->sum('total_cost');
    }
}
