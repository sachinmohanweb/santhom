<?php

namespace App\Http\Repositories;

use App\Models\Family;
use App\Models\FamilyMember;

class UserRepository {

    function __construct() {
        
    }

    // function checkUser($data){
    //     $family=Family::from(with(new Family)->getTable())  
    //                 ->join(with(new FamilyMember)->getTable(). ' as b', 'families.id','b.family_id') 
    //                 ->where('families.family_code',$data['family_code'])
    //                 ->where('b.email',$data['email'])
    //                 ->first();
    //     if($family)
    //     {
    //         return $family;

    //     }else{

    //         return '';
    //     }   
    // }

    function checkUser($data){

        $family=Family::from(with(new Family)->getTable())  
                    ->join(with(new FamilyMember)->getTable(). ' as b', 'families.id','b.family_id')
                    ->select('families.family_code','families.status as family_status','b.email','b.status as member_status') 
                    ->where('families.family_code',$data['family_code'])
                    ->where('b.email',$data['email'])
                    ->first();
        if($family)
        {
            if($family['family_status']==3){
                $status = 2;
            }elseif($family['member_status']==3){
                $status = 3;
            }else{
                $status = 4;
            }

        }else{
            $status = 1;
        }   
        return $status;
    }

    function emailFamilyMember($email,$family_code){

        $family = Family::where('family_code',$family_code)->first();
        $user=FamilyMember::where('email',$email)->where('family_id',$family['id'])->first();
        if($user)
        {
            return $user;
        }else{
            return '';
        }   
    }

}