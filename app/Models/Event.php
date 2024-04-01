<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Event extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'event_name',
        'date',
        'time',
        'venue',
        'details',
        'image',
        'status',
    ];

    protected $appends = ['time_value'];

    public function getStatusAttribute($value)
    {
        return $value == 1 ? 'Active' : 'Suspended';
    }

    public function getTimeVAlueAttribute()
    {   
        $time12 = '';

        if($this->time){
            $time12 = date("h:i A", strtotime($this->time));
        }
        
        return $time12;
    }
}
