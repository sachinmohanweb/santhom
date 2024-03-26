<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class DailySchedules extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'type',
        'day_category',
        'date',
        'details',
        'status',
    ];

    public function getStatusAttribute($value)
    {
        return $value == 1 ? 'Active' : 'Suspended';
    }
    public function getTypeAttribute($value)
    {
        if($value==1){
            return 'Normal Day';
        }else{
            return 'Special Day';

        }
    }

    public function getDayCategoryAttribute($value)
    {
        if($value==1){
            return 'Mon-Sat';
        }else{
            return 'Sunday';

        }
    }
}
