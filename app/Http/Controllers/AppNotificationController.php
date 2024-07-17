<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// use Illuminate\Http\JsonResponse;

use App\Models\FamilyMember;


class AppNotificationController extends Controller
{

    public function sendWebNotification($app_notification_data){

        $url = 'https://fcm.googleapis.com/fcm/send';

        $FcmToken = FamilyMember::whereNotNull('device_id')->pluck('device_id')->all();
   
        dd($url,$FcmToken,$app_notification_data);      
        

        $serverKey = '';
 
        $data = [
            "registration_ids" => $FcmToken,
            "notification" => [
                "title" => $app_notification_data['heading'],
                "body"  => $app_notification_data['body'],  
            ]
        ];
        $encodedData = json_encode($data);
   
        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];
   
        $ch = curl_init();
     
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);        
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);

        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }        

        curl_close($ch);
        
        print_r($result);
    }

}
