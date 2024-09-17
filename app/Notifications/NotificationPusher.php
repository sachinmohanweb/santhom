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

		$title = $msg['title'];
        $body = $msg['body'];
        $imageUrl = "https://santhom.intellyze.in/public/assets/images/logo/logo.svg";
        
        Log::info('data: ', $msg['devicesIds']);

        $AndroidConfig = AndroidConfig::fromArray([
                            'ttl' => '3600s',
                            'priority' => 'normal',
                            'notification' => [
                                'title' => $title,
                                'body' => $body,
                                'icon' => $imageUrl,
                                'color' => '#F4ED20',
                                'sound' => 'default',
                            ],
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
            //->withNotification($notification)
            ->withData(['image' => $imageUrl]);


        $response = Firebase::messaging()->sendMulticast($message,$deviceToken);

        Log::info('FCM Multicast Response', [
            'successCount' => $response->successes()->count(),
            'failureCount' => $response->failures()->count(),
            'failedTokens' => $response->failures()->map(function ($failure) {
                return $failure->target()->value();
            }),
        ]);

		return true;
		
	}
}