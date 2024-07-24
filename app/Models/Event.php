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
        'image2',
        'status',
    ];

    protected $appends = ['time','image_1_name','image_2_name'];

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

    public function getImage1NameAttribute()        
    {
        $name = 'nill';

        if ($this->image !== null) {
           $imagePath = $this->image;
           $prefixToRemove = 'storage/events/';

           $name = substr($imagePath, strlen($prefixToRemove));
        }

        return $name;
    }
    public function getImage2NameAttribute()        
    {
        $name = 'nill';

        if ($this->image2 !== null) {
           $imagePath = $this->image2;
           $prefixToRemove = 'storage/events/';
           
           $name = substr($imagePath, strlen($prefixToRemove));
        }

        return $name;
    }
}
