<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrayerGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_name',
        'leader',
        'leader_phone_ number',
        'status',
    ];



}
