<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

use Auth ;

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
        'map_location',
        'status'
    ];

    protected $appends = ['family_head_name','prayer_group_name','family_head_image'];

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

    public function getPrayerGroupNameAttribute()
    {
        $family = Family::where('id',$this->id)->first();
        $prayer = $family ? $family->PrayerGroup->group_name : 'Null';
        return $prayer;
    }

    public function getFamilyMembersAttribute()
    {
        return $this->hasMany(FamilyMember::class);
    }

    public function getFamilyHeadNameAttribute()
    {
        $familyhead = FamilyMember::where('family_id',$this->id)->where('head_of_family',1)->first();
        $family_head = $familyhead ? $familyhead->name : 'Null';

        return $family_head;
    }

    public function getFamilyHeadImageAttribute()
    {
        $familyhead = FamilyMember::where('family_id',$this->id)->where('head_of_family',1)->first();
        $family_head_image = $familyhead ? $familyhead->image : 'Null';

        if($family_head_image !== null) {
                $family_head_image = asset('/') . $family_head_image;
        }else{
                $family_head_image = null;
        }

        return $family_head_image;
    }
}
