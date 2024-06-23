<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_name',
        'coordinator_id',
        'coordinator',
        'coordinator_phone_number',
        'status',
    ];
    
    protected $appends = ['coordinator_image'];

    public function getStatusAttribute($value)
    {
        return $value == 1 ? 'Active' : 'Suspended';
    }

    public function Officers(){

        return $this->hasMany(OrganizationOfficer::class);
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
