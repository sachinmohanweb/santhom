<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

//use Illuminate\Database\Eloquent\Model;


//class FamilyMember extends Model
class FamilyMember extends Authenticatable
{
    //use HasFactory;
    use HasApiTokens, HasFactory, Notifiable;


    protected $fillable = [
        'title',
        'name',
        'nickname',
        'family_id',
        'head_of_family',
        'gender',
        'dob',
        'date_of_baptism',
        'blood_group_id',
        'marital_status_id',
        'date_of_marriage',
        'relationship_id',
        'qualification',
        'occupation',
        'company_name',
        'email',
        'mobile',
        'alt_contact_no',
        'date_of_death',
        'image',
        'status',
    ];

    protected $appends = ['family_name','family_head_name','prayer_group_name','blood_group_name',
    'marital_status_name','relationship_name'];

    public function Family(){
    
        return $this->belongsTo(Family::class);
    }
    public function Relationship(){
    
        return $this->belongsTo(Relationship::class);
    }
    public function MaritalStatus(){
    
        return $this->belongsTo(MaritalStatus::class);
    }
    public function BloodGroup(){
    
        return $this->belongsTo(BloodGroup::class);
    }

    public function getFamilyNameAttribute()
    {
        $family = Family::where('id',$this->family_id)->first();
        return $family->family_name;
    }

    public function getFamilyHeadNameAttribute()
    {
        $familyhead = FamilyMember::where('family_id',$this->family_id)->where('head_of_family',1)->first();
        $family_head = $familyhead ? $familyhead->name : 'Null';

        return $family_head;
    }
    
    public function getPrayerGroupNameAttribute()
    {
        $family = Family::where('id',$this->family_id)->first();
        $prayer = $family ? $family->PrayerGroup->group_name : 'Null';
        return $prayer;
    }

    public function getBloodGroupNameAttribute()
    {
        $BloodGroup = BloodGroup::where('id',$this->blood_group_id)->first();
        $Blood_Group = $BloodGroup ? $BloodGroup->blood_group_name : 'Null';
        return $Blood_Group;
    }

    public function getMaritalStatusNameAttribute()
    {
        $MaritalStatus = MaritalStatus::where('id',$this->marital_status_id)->first();
        $Marital_Status = $MaritalStatus ? $MaritalStatus->marital_status_name : 'Null';
        return $Marital_Status ;
    }

    public function getRelationshipNameAttribute()
    {
        $Relation = Relationship::where('id',$this->relationship_id)->first();
        $relation = $Relation ? $Relation->relation_name : 'Null';
        return $relation;
    }

}
