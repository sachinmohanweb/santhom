<?php
namespace App\Notifications;

use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Messaging\AndroidConfig;
use Kreait\Firebase\Messaging\ApnsConfig;
use Kreait\Firebase\Messaging\WebPushConfig;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Kreait\Firebase\Messaging\MulticastMessage;


use Illuminate\Support\Facades\Log; 

class NotificationPusher
{
	
	public function __construct()
	{	
		
	}


	public function push($msg)
	{

        $deviceToken = $msg['devicesIds'];
		$title       = $msg['title'];
        $body        = $msg['body'];

        $route       = $msg['route'];
        $id          = $msg['id'];
        $category    = $msg['category'];
        $data1       = $msg['data1'];
        $data2       = $msg['data2'];
        $data3       = $msg['data3'];
        $data4       = $msg['data4'];
        $data5       = $msg['data5'];
        $data6       = $msg['data6'];
        $image1      = $msg['image1'];
        $image2      = $msg['image2'];

        $imageUrl = "https://santhom.intellyze.in/public/assets/images/logo/logo.svg";
        
        Log::info('data: ', $msg['devicesIds']);

        $AndroidConfig = AndroidConfig::fromArray([
                            'ttl' => '3600s',
                            'priority' => 'normal',
                            'notification' => [
                                'title' => $title,
                                'body'  => $body,
                                'color' => '#2c5acf',
                            ],
                            'data' => [
                                'click_action'      => $route,
                                'table_id'          => (string) $id,
                                'category'          => $category,
                                'data1'             => $data1,
                                'data2'             => $data2,
                                'data3'             => $data3,
                                'data4'             => $data4,
                                'data5'             => $data5,
                                'data6'             => $data6,
                                'image1'            => $image1,
                                'image2'            => $image2,
                            ]
                        ]);

        $ApnsConfig = ApnsConfig::fromArray([
                        'headers' => [
                            'apns-priority' => '10',
                        ],
                        'payload' => [
                            'aps' => [
                                'alert' => [
                                    'title' => $title,
                                    'body' => $body,
                                ],
                                'badge' => 42,
                                'sound' => 'default',
                            ],

                            'image_url' => $imageUrl,

                            'table_id' => (string) $id,

                            'custom_data' => [
                                'action_route' => $route
                            ],
                        ],
                    ]);

        $webconfig = WebPushConfig::fromArray([
            'notification' => [
                'title' => $title,
                'body' => $body,
                'icon' => $imageUrl,
            ],
            'fcm_options' => [
                'link' => '',
            ],
        ]);

        $message = CloudMessage::new()
            ->withAndroidConfig($AndroidConfig)
            ->withApnsConfig($ApnsConfig)
            ->withWebPushConfig($webconfig)
            ->withData(['image' => $imageUrl]);


        $response = Firebase::messaging()->sendMulticast($message,$deviceToken);

        Log::info('FCM Multicast Response', [
            'type' => $route,
            'successCount' => $response->successes()->count(),
            'failureCount' => $response->failures()->count(),
            'failedTokens' => $response->failures()->map(function ($failure) {
                return [
                    'token' => $failure->target()->value(),
                    'error' => $failure->error()->getMessage(),
                ];
            }),
        ]);

		return true;
		
	}
}