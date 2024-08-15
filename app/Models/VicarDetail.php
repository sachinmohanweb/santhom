<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VicarDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'name',
        'family_name',
        'dob',
        'gender',
        'date_of_fhc',
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
        if($value == 1){
            return 'Vicar';
        }else if($value == 2){
            return 'Asst.Vicar';
        }else if($value == 3){
            return 'Sister';
        }else if($value == 4){
            return 'Animator';
        }else if($value == 5){
            return 'Deacon';
        }else if($value == 6){
            return 'Sacristan';
        }
    }

    public function getDOBAttribute()
    {
            if(!empty($this->attributes['dob'])) {
                $date = new \DateTime($this->attributes['dob']);
                return $date->format('d/m/Y');
            }
            return null;
    }
    public function getDateOfJoiningAttribute()
    {
            if(!empty($this->attributes['date_of_joining'])) {
                $date = new \DateTime($this->attributes['date_of_joining']);
                return $date->format('d/m/Y');
            }
            return null;
    }
    public function getDateOfRelievingAttribute()
    {
            if(!empty($this->attributes['date_of_relieving'])) {
                $date = new \DateTime($this->attributes['date_of_relieving']);
                return $date->format('d/m/Y');
            }
            return null;
    }
    public function getDateOfFHCAttribute()
    {
            if(!empty($this->attributes['date_of_fhc'])) {
                $date = new \DateTime($this->attributes['date_of_fhc']);
                return $date->format('d/m/Y');
            }
            return null;
    }

    public function getRawDOB()
    {
        return $this->attributes['dob'];
    }

    public function getRawDateOfJoining()
    {
        return $this->attributes['date_of_joining'];
    }

    public function getRawDateOfRelieving()
    {
        return $this->attributes['date_of_relieving'];
    }
    public function getRawDateOfFHC()
    {
        return $this->attributes['date_of_fhc'];
    }

}
