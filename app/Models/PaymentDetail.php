<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class PaymentDetail extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'member_id',
        'member',
        'purpose',
        'date',
        'amount',
        'status',
    ];

    public function getStatusAttribute($value)
    {
        return $value == 1 ? 'Active' : 'Suspended';
    }

}
