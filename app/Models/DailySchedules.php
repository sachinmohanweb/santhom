<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class DailySchedules extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'time',
        'title',
        'venue',
        'details',
        'status',
    ];

    public function getStatusAttribute($value)
    {
        return $value == 1 ? 'Active' : 'Suspended';
    }

}
