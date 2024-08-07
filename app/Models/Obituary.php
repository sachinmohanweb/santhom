<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Obituary extends Model
{
    use HasFactory;

    protected $appends = ['time'];

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

    public function getTimeAttribute()
    {   
        $time12 = '';

        if($this->funeral_time){
            $time12 = date("h:i A", strtotime($this->funeral_time));
        }
        
        return $time12;
    }
    public function getDateOfDeathAttribute()
    {
            if(!empty($this->attributes['date_of_death'])) {
                $date = new \DateTime($this->attributes['date_of_death']);
                return $date->format('d/m/Y');
            }
            return null;
    }
    public function getRawDateOfDeath()
    {
        return $this->attributes['date_of_death'];
    }

    public function getDisplayTillDateAttribute()
    {
            if(!empty($this->attributes['display_till_date'])) {
                $date = new \DateTime($this->attributes['display_till_date']);
                return $date->format('d/m/Y');
            }
            return null;
    }
    public function getRawDisplayTillDate()
    {
        return $this->attributes['display_till_date'];
    }

    public function getFuneralDateAttribute()
    {
            if(!empty($this->attributes['funeral_date'])) {
                $date = new \DateTime($this->attributes['funeral_date']);
                return $date->format('d/m/Y');
            }
            return null;
    }
    public function getRawFuneralDate()
    {
        return $this->attributes['funeral_date'];
    }
}
