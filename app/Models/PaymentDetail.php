<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class PaymentDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'effective_date',
        'family_id',
        'family_head_id',
        'category_id',
        'amount',
        'status',
    ];

    protected $appends = ['family_name','family_head_name','category_name','date'];

    public function getStatusAttribute($value)
    {
        return $value == 1 ? 'Active' : 'Suspended';
    }

    public function getFamilyNameAttribute()
    {
        $family = Family::where('id',$this->family_id)->first();
        if($family){
            return $family->family_name;
        }else{
            return "Nill";
        }
    }
    
    public function getFamilyHeadNameAttribute()
    {
        $familyhead = FamilyMember::where('id',$this->family_head_id)->first();
        $family_head = $familyhead ? $familyhead->name : 'Null';

        return $family_head;
    }

    public function getCategoryNameAttribute()
    {
        $payment = PaymentCategory::where('id',$this->category_id)->first();
        $payment = $payment ? $payment->name : 'Null';

        return $payment;
    }

    public function getDateAttribute()
    {
        $date = $this->effective_date;
        $date = new \DateTime($date);
        $formatted_date = $date->format('d-m-Y');
        return $formatted_date;
    }

}
