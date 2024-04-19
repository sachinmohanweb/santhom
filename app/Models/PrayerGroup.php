<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrayerGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_name',
        'leader_id',
        'leader',
        'leader_phone_number',
        'coordinator_id',
        'coordinator_name',
        'coordinator_phone',
        'status',
    ];

    public function getStatusAttribute($value)
    {
        return $value == 1 ? 'Active' : 'Suspended';
    }
}
