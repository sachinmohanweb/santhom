<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationOfficer extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'member_id',
        'member_name',
        'position',
        'officer_phone_number',
        'status',
    ];

    public function getStatusAttribute($value)
    {
        return $value == 1 ? 'Active' : 'Suspended';
    }

}
