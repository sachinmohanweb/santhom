<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
Use App\Models\Family;
Use App\Models\Relationship;

class FamilyMember extends Model
{
    use HasFactory;

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

    public function Family(){
    
        return $this->belongsTo(Family::class);
    }
    public function Relationship(){
    
        return $this->belongsTo(Relationship::class);
    }


}
