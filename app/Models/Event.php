<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_name',
        'date',
        'time_value',
        'venue',
        'link',
        'details',
        'image',
        'status',
    ];

    protected $appends = ['time'];

    public function getStatusAttribute($value)
    {
        return $value == 1 ? 'Active' : 'Suspended';
    }

    public function getTimeAttribute()
    {   
        $time12 = '';

        if($this->time_value){
            $time12 = date("h:i A", strtotime($this->time_value));
        }
        
        return $time12;
    }
}
