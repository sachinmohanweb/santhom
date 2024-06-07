<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\SettingsController;
use App\Http\Controllers\Api\HomeController;

Route::post('login',[UserController::class, 'loginUser']);
Route::post('verify_otp',[UserController::class, 'VerifyOtp']);
Route::get('/clear',[SettingsController::class,'ClearCache']);

Route::middleware('auth:sanctum')->group(function(){

    Route::get('logout',[UserController::class, 'logoutuser']);
    Route::post('update_token',[UserController::class, 'updateToken']);

    Route::get('my_profile',[UserController::class, 'myprofile']);
    Route::post('update_family',[UserController::class, 'updateFamily']);
    Route::get('my_family',[UserController::class, 'myfamily']);
    Route::post('add_member',[UserController::class, 'addMember']);
    Route::post('update_member',[UserController::class, 'updateMember']);
    Route::get('family',[UserController::class, 'family']);
    Route::get('family_member',[UserController::class, 'familyMember']);
    Route::get('vicars_list',[UserController::class, 'VicarsList']);
    Route::get('vicar_details',[UserController::class, 'VicarDetails']);
    Route::post('delete_member', [UserController::class, 'DeleteMember']);

    Route::get('blood_groups',[SettingsController::class, 'BloodGroups']);
    Route::get('marital_statuses',[SettingsController::class, 'MaritatStatuses']);
    Route::get('relationships',[SettingsController::class, 'Relationships']);
    
    Route::get('prayer_groups',[SettingsController::class, 'PrayerGroups']);
    Route::get('prayer_group_details',[SettingsController::class, 'PrayerGroupDetails']);
    Route::get('organizations',[SettingsController::class, 'Organizations']);
    Route::get('organization_details',[SettingsController::class, 'OrganizationDetails']);
    Route::get('directory',[HomeController::class, 'Directory']);
    Route::get('daily_digest',[HomeController::class, 'DailyDigest']);
    Route::get('vicar_messages',[HomeController::class, 'VicarMessages']);
    Route::get('notifications',[HomeController::class, 'Notifications']);
    Route::get('bulletin',[HomeController::class, 'Bulletin']);
    Route::get('yearly_calender_events',[HomeController::class, 'YearlyCalenderEvents']);
    Route::get('daily_calender_events',[HomeController::class, 'DailyCalenderEvents']);

    Route::get('downloads',[HomeController::class, 'Downloads']);
    Route::get('contributions',[HomeController::class, 'Contributions']);

    // Route::get('families',[HomeController::class, 'Families']);
    // Route::get('members',[HomeController::class, 'Members']);
    // Route::get('bible_verses',[HomeController::class, 'BibleVerses']);
    // Route::get('daily_schedules',[HomeController::class, 'DailySchedules']);
    // Route::get('event',[HomeController::class, 'BirthDay']);
    // Route::get('birth_day',[HomeController::class, 'BirthDay']);
    // Route::get('obituary',[HomeController::class, 'BirthDay']);

    // Route::get('events',[HomeController::class, 'Events']);
    // Route::get('news_announcements',[HomeController::class, 'NewsAnnouncements']);
    // Route::get('obituaries',[HomeController::class, 'Obituaries']);

});

