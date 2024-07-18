<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrayerMeeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'prayer_group_id',
        'family_id',
        'date',
        'time',
        'status',
    ];

    public function getStatusAttribute($value)
    {
        return $value == 1 ? 'Active' : 'Suspended';
    }

    public function PrayerGroup(){
    
        return $this->belongsTo(PrayerGroup::class);
    }
    public function Family(){
    
        return $this->belongsTo(Family::class);
    }

}
