<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class MemoryDay extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'memory_type_id',
        'date',
        'title',
        'note1',
        'note2',
        'status',
    ];

    protected $appends = ['memory_day_type_name'];

    public function getStatusAttribute($value)
    {
        return $value == 1 ? 'Active' : 'Suspended';
    }

    public function getMemoryDayTypeNameAttribute()
    {
        $type = MemoryType::where('id',$this->memory_type_id)->first();

        $type_name = $type ? $type->type_name : 'Null';

        return $type_name;
    }
}
