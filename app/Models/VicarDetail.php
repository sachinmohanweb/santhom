<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VicarDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'family_name',
        'dob',
        'designation',
        'date_of_joining',
        'date_of_relieving',
        'email',
        'mobile',
        'photo',
        'status',
    ];

    public function getStatusAttribute($value)
    {
        return $value == 1 ? 'Active' : 'Suspended';
    }

    public function getDesignationAttribute($value)
    {
        return $value == 1 ? 'Vicar' : 'Asst.Vicar';
    }
}
