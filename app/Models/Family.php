<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    use HasFactory;

    protected $fillable = [
        'family_code',
        'family_name',
        'family_email',
        'head_of_family',
        'prayer_group',
        'address1',
        'address2',
        'pincode'
    ];



}
