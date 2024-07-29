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
}
