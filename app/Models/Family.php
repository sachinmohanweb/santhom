<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;


class Family extends Model
{
    use HasFactory;

    protected $fillable = [
        'family_code',
        'family_name',
        'family_email',
        'prayer_group_id',
        'address1',
        'address2',
        'post_office',
        'pincode',
        'map_location'
    ];

    public function PrayerGroup(){
    
        return $this->belongsTo(PrayerGroup::class);
    }

    public function Members(){

        return $this->hasMany(FamilyMember::class);
    }

    public function headOfFamily(): HasOne
    {
        return $this->hasOne(FamilyMember::class)->where('relationship_id', 1);
    }
    
}
