<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsAnnouncement extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'heading',
        'body',
        'designation',
        'image',
    ];

    public function getStatusAttribute($value)
    {
        return $value == 1 ? 'Active' : 'Suspended';
    }

}
