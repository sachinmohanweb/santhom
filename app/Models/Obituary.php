<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Obituary extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'name_of_member',
        'date_of_death',
        'funeral_date',
        'funeral_time',
        'display_till_date',
        'date_of_relieving',
        'notes',
        'photo',
        'status',
    ];

    public function getStatusAttribute($value)
    {
        return $value == 1 ? 'Active' : 'Suspended';
    }
}
