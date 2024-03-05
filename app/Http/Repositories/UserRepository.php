<?php

namespace App\Http\Repositories;

use App\Models\Family;
use App\Models\FamilyMember;

class UserRepository {

    function __construct() {
        
    }

    function checkUser($data){
        $family=Family::from(with(new Family)->getTable())  
                    ->join(with(new FamilyMember)->getTable(). ' as b', 'families.id','b.family_id') 
                    ->where('families.family_code',$data['family_code'])
                    ->where('b.email',$data['email'])
                    ->first();
        if($family)
        {
            return $family;

        }else{

            return '';
        }   
    }

    function emailFamilyMember($email){

        $user=FamilyMember::where('email',$email)->first();
        if($user)
        {
            return $user;
        }else{
            return '';
        }   
    }

}