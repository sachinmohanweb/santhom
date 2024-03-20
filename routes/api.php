<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\SettingsController;
use App\Http\Controllers\Api\HomeController;

Route::post('login',[UserController::class, 'loginUser']);
Route::post('verify_otp',[UserController::class, 'VerifyOtp']);

Route::middleware('auth:sanctum')->group(function(){

    Route::get('logout',[UserController::class, 'logoutuser']);

    Route::get('my_profile',[UserController::class, 'myprofile']);
    Route::post('update_family/{family_id}',[UserController::class, 'updateFamily']);
    Route::get('my_family',[UserController::class, 'myfamily']);
    Route::post('add_member',[UserController::class, 'addMember']);
    Route::post('update_member/{member_id}',[UserController::class, 'updateMember']);

    Route::get('blood_groups',[SettingsController::class, 'BloodGroups']);
    Route::get('marital_statuses',[SettingsController::class, 'MaritatStatuses']);
    Route::get('relationships',[SettingsController::class, 'Relationships']);
    
    Route::get('bible_verses',[HomeController::class, 'BibleVerses']);

    // Route::get('families',[HomeController::class, 'Families']);
    // Route::get('members',[HomeController::class, 'Members']);
    // Route::get('prayer_groups',[SettingsController::class, 'PrayerGroups']);
    // Route::get('organizations',[HomeController::class, 'Organizations']);
    Route::get('directory',[HomeController::class, 'Directory']);

    
    // Route::get('daily_schedules',[HomeController::class, 'DailySchedules']);
    // Route::get('event',[HomeController::class, 'BirthDay']);
    // Route::get('birth_day',[HomeController::class, 'BirthDay']);
    // Route::get('obituary',[HomeController::class, 'BirthDay']);
    Route::get('daily_digest',[HomeController::class, 'DailyDigest']);

    // Route::get('events',[HomeController::class, 'Events']);
    // Route::get('news_announcements',[HomeController::class, 'NewsAnnouncements']);
    // Route::get('notifications',[HomeController::class, 'Notifications']);
    // Route::get('obituaries',[HomeController::class, 'Obituaries']);
    // Route::get('vicar_messages',[HomeController::class, 'VicarMessages']);
    Route::get('bulletin',[HomeController::class, 'Bulletin']);
});

