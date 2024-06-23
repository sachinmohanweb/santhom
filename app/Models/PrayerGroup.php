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

    protected $appends = ['leader_image','coordinator_image'];

    public function getStatusAttribute($value)
    {
        return $value == 1 ? 'Active' : 'Suspended';
    }

    public function getLeaderImageAttribute()
    {
        $leader = FamilyMember::where('id',$this->leader_id)->first();
        if ($leader) {
            if ($leader->image !== null) {
                $leader->image = asset('/') . $leader->image;
            }
            return $leader->image;
        }

        return 'Null';
    }

    public function getCoordinatorImageAttribute()
    {
        $coordinator = FamilyMember::where('id',$this->coordinator_id)->first();
        if ($coordinator) {
            if ($coordinator->image !== null) {
                $coordinator->image = asset('/') . $coordinator->image;
            }
            return $coordinator->image;
        }

        return 'Null';
    }
}
