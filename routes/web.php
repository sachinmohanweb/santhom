<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\PrayerGroupController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\VicarDetailsController;
use App\Http\Controllers\VicarMessageController;
use App\Http\Controllers\BibleVerseController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\NewsAnnouncementController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\ObituaryController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PaymentDetailsController;
use App\Http\Controllers\BiblicalCitationController;
use App\Http\Controllers\MemoriesController;
use App\Http\Controllers\DailyScheduleController;



Route::get('/', [HomeController::class, 'admin_index'])->name('index');
Route::post('/login', [UserController::class, 'admin_login'])->name('admin.login');

Route::middleware('auth:admin')->group(function(){

    Route::get('/logout', [UserController::class, 'admin_logout'])->name('admin.logout');
    Route::get('/dashboard', [HomeController::class, 'admin_dashboard'])->name('admin.dashboard');

    Route::get('/familylist', [FamilyController::class, 'admin_family_list'])
            ->name('admin.family.list');
    Route::post('/familyDatatable', [FamilyController::class, 'admin_family_Datatable'])
            ->name('admin.family.list.datatable');
    Route::get('/createfamily', [FamilyController::class, 'admin_family_create'])
            ->name('admin.family.create');
    Route::post('/storefamily', [FamilyController::class, 'admin_family_store'])
            ->name('admin.family.store');
    Route::get('/showfamily/{id}', [FamilyController::class, 'admin_family_show'])
            ->name('admin.family.show_details');
    Route::post('/updatefamily', [FamilyController::class, 'admin_family_update'])
            ->name('admin.family.update');
    Route::post('/deletefamily', [FamilyController::class, 'admin_family_delete'])
            ->name('admin.family.delete');
    Route::post('/block_unblock_family', [FamilyController::class, 'admin_family_block_unblock'])
            ->name('admin.family.block_unblock');

    Route::get('/familymemberslist', [FamilyController::class, 'admin_family_members_list'])
            ->name('admin.family.members.list');
    Route::get('/familymembersDatatable',[FamilyController::class,'admin_family_members_Datatable'])
            ->name('admin.familymembers.list.datatable');
    Route::get('/createfamilymember', [FamilyController::class, 'admin_family_member_create'])
            ->name('admin.family.member.create');
    Route::get('/createfamilymember/{family_id}', [FamilyController::class, 'admin_family_member_create'])
            ->name('admin.family.member.create.family_id');
    Route::post('/storefamilymember', [FamilyController::class, 'admin_family_member_store'])
            ->name('admin.family.member.store');
    Route::get('/showfamilymember/{id}', [FamilyController::class, 'admin_family_member_show'])
            ->name('admin.family.member.show_details');
    Route::get('/editfamilymember/{id}', [FamilyController::class, 'admin_family_member_edit'])
            ->name('admin.family.member.edit');
    Route::post('/updatefamilymember', [FamilyController::class, 'admin_family_member_update'])
            ->name('admin.family.member.update');
    Route::post('/deletefamilymember', [FamilyController::class, 'admin_family_member_delete'])
            ->name('admin.family.member.delete');
    Route::post('/check_married_to_person_valid', [FamilyController::class, 'CheckMarriedToPersonValid'])
            ->name('admin.check.married.valid');   
    Route::post('/get_member_phone_number', [FamilyController::class, 'GetMemberPhoneNumber'])
            ->name('admin.get.member.phone');   
    Route::post('/block_unblock_member', [FamilyController::class, 'admin_member_block_unblock'])
            ->name('admin.member.block_unblock');  

    Route::get('/importfamilymember', [FamilyController::class, 'admin_family_member_import'])
            ->name('admin.family.members.import');
    Route::post('import/progress'  ,[FamilyController::class,'import_progress'])
            ->name('import.progress');
    Route::post('/storefamilymemberimport', [FamilyController::class, 'admin_family_member_import_store'])
            ->name('admin.family.members.Import.store');

    Route::post('/get_family_members_list', [FamilyController::class, 'family_members_list'])
            ->name('family.members.list');
    Route::post('/check_famiy_head_updated', [FamilyController::class, 'checkFamiyHeadUpdated'])
            ->name('family.head.updated');

    Route::get('/familylist_pending', [FamilyController::class, 'admin_family_list_pending'])
            ->name('admin.family.list.pending');
    Route::post('/family_pendingDatatable', [FamilyController::class, 'admin_family_Datatable_pending'])
            ->name('admin.family.list.datatable.pending');
    Route::get('/showfamily_pending/{id}', [FamilyController::class, 'admin_family_show_pending'])
            ->name('admin.family.show_details.pending');
    Route::post('/approvefamily', [FamilyController::class, 'admin_family_approve'])
            ->name('admin.family.approve');

    Route::get('/familymemberslist_pending', [FamilyController::class, 'admin_family_members_list_pending'])
            ->name('admin.family.members.list.pending');
    Route::get('/familymembers_pendingDatatable',[FamilyController::class,'admin_family_members_Datatable_pending'])->name('admin.familymembers.list.datatable.pending');
    Route::get('/showfamilymember_pending/{id}',[FamilyController::class,'admin_family_member_show_pending'])
            ->name('admin.family.member.show_details.pending');
     Route::post('/approvefamilymember', [FamilyController::class, 'admin_family_member_approve'])
            ->name('admin.family.member.approve');
    Route::post('/get_family_list', [FamilyController::class, 'GetFamilies'])->name('admin.get.families');

    Route::get('/prayerGroupList', [PrayerGroupController::class, 'prayer_group_list'])
            ->name('admin.prayergroup.list');
    Route::get('/prayerGroupDatatable', [PrayerGroupController::class, 'prayer_group_datatable'])
            ->name('admin.prayergroup.datatable');
    Route::post('/storeprayerGroup', [PrayerGroupController::class, 'prayer_group_store'])
            ->name('admin.prayergroupr.store');
    Route::post('/getprayerGroup', [PrayerGroupController::class, 'prayer_group_get'])
            ->name('admin.get.prayergroup');
    Route::post('/updateprayergroup/{id}', [PrayerGroupController::class, 'prayer_group_update'])
            ->name('admin.prayergroup.update');
    Route::post('/deleteprayerGroup', [PrayerGroupController::class, 'prayer_group_delete'])
            ->name('admin.prayergroup.delete');

    Route::get('/prayerMeetingsList', [PrayerGroupController::class, 'prayer_meetings_list'])
            ->name('admin.prayermeetings.list');
    Route::get('/prayerMeetingsDatatable', [PrayerGroupController::class, 'prayer_meetings_datatable'])
            ->name('admin.prayermeetings.datatable');
    Route::get('/createprayerMeetings', [PrayerGroupController::class, 'prayer_meetings_create'])
            ->name('admin.prayermeetings.create');
    Route::post('/storeprayerMeetings', [PrayerGroupController::class, 'prayer_meetings_store'])
            ->name('admin.prayermeetings.store');
    Route::get('/editprayermeetings/{id}', [PrayerGroupController::class, 'prayer_meetings_edit'])
            ->name('admin.prayermeetings.edit');
            
    Route::post('/updateprayerMeetings/{id}', [PrayerGroupController::class, 'prayer_meetings_update'])
            ->name('admin.prayermeetings.update');
    Route::post('/deleteprayerMeetings', [PrayerGroupController::class, 'prayer_meetings_delete'])
            ->name('admin.prayermeetings.delete');

    Route::get('/organizationsList', [OrganizationController::class, 'organizations_list'])
            ->name('admin.organizations.list');
    Route::get('/organizationsDatatable', [OrganizationController::class, 'organizations_datatable'])
            ->name('admin.organizations.datatable');
    Route::post('/storeorganizations', [OrganizationController::class, 'organizations_store'])
            ->name('admin.organizations.store');
    Route::get('/showorganization/{id}', [OrganizationController::class, 'Organization_show'])
            ->name('admin.organizations.show_details');
    Route::post('/getorganizations', [OrganizationController::class, 'organizations_get'])
            ->name('admin.get.organizations');
    Route::post('/updateorganizations/{id}', [OrganizationController::class, 'organizations_update'])
            ->name('admin.organizations.update');
    Route::post('/deleteorganizations', [OrganizationController::class, 'organizations_delete'])
            ->name('admin.organizations.delete');
    Route::post('/get_group_org_list', [OrganizationController::class, 'getGroupOrgList'])
            ->name('admin.group.organization.list');
    Route::post('/get_current_group_org', [OrganizationController::class, 'getCurrentGroupOrg'])
            ->name('admin.group.organization.current');

    Route::post('/storeorganizationofficers', [OrganizationController::class,
            'store_organization_officers'])->name('admin.organization.officer.store');
    Route::post('/deleteorganizationofficer', [OrganizationController::class, 
            'organization_officer_delete'])->name('admin.organization.officer.delete');
    Route::post('/getorganizationofficers', [OrganizationController::class, 'organizations_officer_get'])
            ->name('admin.get.organization.officers');
    Route::post('/updateorganizationofficers', [OrganizationController::class,
            'update_organization_officers'])->name('admin.organization.officer.update');

    Route::get('/vicarlist', [VicarDetailsController::class, 'vicars_list'])
            ->name('admin.vicar.list');
    Route::get('/vicarDatatable', [VicarDetailsController::class, 'vicars_Datatable'])
            ->name('admin.vicar.list.datatable');
    Route::get('/createvicar', [VicarDetailsController::class, 'vicar_create'])
            ->name('admin.vicar.create');
    Route::post('/storevicar', [VicarDetailsController::class, 'vicar_store'])
            ->name('admin.vicar.store');
    Route::get('/showvicar/{id}', [VicarDetailsController::class, 'vicar_show'])
            ->name('admin.vicar.show_details');
    Route::post('/updatevicar', [VicarDetailsController::class, 'vicar_update'])
            ->name('admin.vicar.update');
    Route::post('/deletevicar', [VicarDetailsController::class, 'vicar_delete'])
            ->name('admin.vicar.delete');

     Route::get('/vicarmessages_list', [VicarMessageController::class, 'vicar_message_list'])
            ->name('admin.vicarmessages.list');
    Route::get('/vicarmessages_Datatable', [VicarMessageController::class, 'vicars_message_Datatable'])
            ->name('admin.vicarmessages.datatable');
    Route::get('/create_vicarmessages', [VicarMessageController::class, 'vicar_message_create'])
            ->name('admin.vicarmessages.create');
    Route::post('/store_vicarmessages', [VicarMessageController::class, 'vicar_message_store'])
            ->name('admin.vicarmessages.store');
    Route::get('/show_vicarmessages/{id}', [VicarMessageController::class, 'vicar_message_show'])
            ->name('admin.vicarmessages.show_details');
    Route::get('/edit_vicarmessages/{id}', [VicarMessageController::class, 'vicar_message_edit'])
            ->name('admin.vicarmessages.edit');
    Route::post('/update_vicarmessages', [VicarMessageController::class, 'vicar_message_update'])
            ->name('admin.vicarmessages.update');
    Route::post('/delete_vicarmessages', [VicarMessageController::class, 'vicar_message_delete'])
            ->name('admin.vicarmessages.delete');

    Route::get('/bibleverselist', [BibleVerseController::class, 'bible_verse_list'])
            ->name('admin.bibleverse.list');
    Route::get('/bibleversedatatable', [BibleVerseController::class, 'bible_verse_datatable'])
            ->name('admin.bibleverse.datatable');
    Route::post('/storebibleverse', [BibleVerseController::class, 'bible_verse_store'])
            ->name('admin.bibleverse.store');
    Route::post('/getbibleverse', [BibleVerseController::class, 'bible_verse_get'])
            ->name('admin.get.bibleverse');
    Route::post('/updatebibleverse/{id}', [BibleVerseController::class, 'bible_verse_update'])
            ->name('admin.bibleverse.update');
    Route::post('/deletebibleverse', [BibleVerseController::class, 'bible_verse_delete'])
            ->name('admin.bibleverse.delete');
    Route::get('/importbibleverse', [BibleVerseController::class, 'admin_bible_verse_import'])
            ->name('admin.bibleverse.import');
    Route::post('import/progress/bibleverse'  ,[BibleVerseController::class,'import_progress_bible_verse'])
            ->name('import.progress.bibleverse');
    Route::post('/storebibleverseimport', [BibleVerseController::class, 'admin_bible_verse_import_store'])
            ->name('admin.bible.verse.Import.store');

    Route::get('/eventlist', [EventController::class, 'event_list'])
            ->name('admin.event.list');
    Route::get('/eventDatatable', [EventController::class, 'event_Datatable'])
            ->name('admin.event.datatable');
    Route::get('/createevent', [EventController::class, 'event_create'])
            ->name('admin.event.create');
    Route::post('/storeevent', [EventController::class, 'event_store'])
            ->name('admin.event.store');
    Route::get('/showevent/{id}', [EventController::class, 'event_show'])
            ->name('admin.event.show_details');
    Route::post('/updateevent', [EventController::class, 'event_update'])
            ->name('admin.event.update');
    Route::post('/deleteevent', [EventController::class, 'event_delete'])
            ->name('admin.event.delete');

    Route::get('/newsannouncementlist', [NewsAnnouncementController::class, 'news_announcement_list'])
            ->name('admin.news_announcement.list');
    Route::get('/newsannouncementDatatable',[NewsAnnouncementController::class,'news_announcemnt_Datatable'])
            ->name('admin.news_announcement.datatable');
    Route::get('/createnewsannouncement', [NewsAnnouncementController::class, 'news_announcement_create'])
            ->name('admin.news_announcement.create');
    Route::post('/storenewsannouncement', [NewsAnnouncementController::class, 'news_announcement_store'])
            ->name('admin.news_announcement.store');
    Route::get('/shownewsannouncement/{id}', [NewsAnnouncementController::class, 'news_announcement_show'])
            ->name('admin.news_announcement.show_details');
    Route::post('/updatenewsannouncement', [NewsAnnouncementController::class, 'news_announcement_update'])
            ->name('admin.news_announcement.update');
    Route::post('/deletenewsannouncement', [NewsAnnouncementController::class, 'news_announcement_delete'])
            ->name('admin.news_announcement.delete');

    Route::get('/downloadList', [DownloadController::class, 'download_list'])
            ->name('admin.download.list');
    Route::get('/downloadDatatable', [DownloadController::class, 'download_datatable'])
            ->name('admin.download.datatable');
    Route::post('/storedownload', [DownloadController::class, 'download_store'])
            ->name('admin.download.store');
    Route::post('/getdownload', [DownloadController::class, 'download_get'])
            ->name('admin.get.download');
    Route::post('/updatedownload/{id}', [DownloadController::class, 'download_update'])
            ->name('admin.download.update');
    Route::post('/deletedownload', [DownloadController::class, 'download_delete'])
            ->name('admin.download.delete');

    Route::get('/obituarylist', [ObituaryController::class, 'obituary_list'])
            ->name('admin.obituary.list');
    Route::get('/obituaryDatatable',[ObituaryController::class,'obituary_Datatable'])
            ->name('admin.obituary.datatable');
    Route::get('/createobituary', [ObituaryController::class, 'obituary_create'])
            ->name('admin.obituary.create');
    Route::post('/storeobituary', [ObituaryController::class, 'obituary_store'])
            ->name('admin.obituary.store');
    Route::get('/showobituary/{id}', [ObituaryController::class, 'obituary_show'])
            ->name('admin.obituary.show_details');
    Route::post('/updateobituary', [ObituaryController::class, 'obituary_update'])
            ->name('admin.obituary.update');
    Route::post('/deleteobituary', [ObituaryController::class, 'obituary_delete'])
            ->name('admin.obituary.delete');

    Route::get('/notificationlist', [NotificationController::class, 'notification_list'])
            ->name('admin.notification.list');
    Route::get('/notificationDatatable',[NotificationController::class,'notification_Datatable'])
            ->name('admin.notification.datatable');
    Route::get('/createnotification', [NotificationController::class, 'notification_create'])
            ->name('admin.notification.create');
    Route::post('/storenotification', [NotificationController::class, 'notification_store'])
            ->name('admin.notification.store');
    Route::get('/shownotification/{id}', [NotificationController::class, 'notification_show'])
            ->name('admin.notification.show_details');
    Route::post('/updatenotification', [NotificationController::class, 'notification_update'])
            ->name('admin.notification.update');
    Route::post('/deletenotification', [NotificationController::class, 'notification_delete'])
            ->name('admin.notification.delete');

    Route::get('/paymentdetailslist', [PaymentDetailsController::class, 'payment_details_list'])
            ->name('admin.paymentdetails.list');
    Route::get('/paymentdetailsDatatable',[PaymentDetailsController::class,'payment_details_Datatable'])
            ->name('admin.paymentdetails.datatable');
    Route::get('/createpaymentdetails', [PaymentDetailsController::class, 'payment_details_create'])
            ->name('admin.paymentdetails.create');
    Route::post('/storepaymentdetails', [PaymentDetailsController::class, 'payment_details_store'])
            ->name('admin.paymentdetails.store');
    Route::get('/showpaymentdetails/{id}', [PaymentDetailsController::class, 'payment_details_show'])
            ->name('admin.paymentdetails.show_details');
    Route::post('/updatepaymentdetails', [PaymentDetailsController::class, 'payment_details_update'])
            ->name('admin.paymentdetails.update');
    Route::post('/deletepaymentdetails', [PaymentDetailsController::class, 'payment_details_delete'])
            ->name('admin.paymentdetails.delete');

    Route::post('/get_payment_categorylist', [PaymentDetailsController::class, 'payment_category_list'])
            ->name('payment.category.list');
    Route::get('/paymentcategorieslist', [PaymentDetailsController::class, 'payment_categories_list'])
            ->name('admin.paymentcategories.list');
    Route::get('/paymentcategoriesDatatable',[PaymentDetailsController::class,'payment_categories_Datatable'])
            ->name('admin.paymentcategories.datatable');
    Route::get('/createpaymentcategories', [PaymentDetailsController::class, 'payment_categories_create'])
            ->name('admin.paymentcategories.create');
    Route::post('/storepaymentcategories', [PaymentDetailsController::class, 'payment_categories_store'])
            ->name('admin.paymentcategories.store');
    Route::post('/deletepaymentcategories', [PaymentDetailsController::class, 'payment_categories_delete'])
            ->name('admin.paymentcategories.delete');

    Route::get('/importcontributions', [PaymentDetailsController::class, 'admin_contributions_import'])
            ->name('admin.contributions.import');
    Route::post('import/progress/contributions'  ,[PaymentDetailsController::class,'import_progress_contributions'])
            ->name('import.progress.contributions');
    Route::post('/storecontributionsimport', [PaymentDetailsController::class, 'admin_contributions_import_store'])
            ->name('admin.contributions.Import.store');

    Route::get('/biblicalcitationlist', [BiblicalCitationController::class, 'admin_biblical_citation_list'])
                    ->name('admin.biblical.citation.list');
    Route::get('/biblicalcitationDatatable',[BiblicalCitationController::class,
                'admin_bible_citation_Datatable'])->name('admin.biblical.citation.list.datatable');
    Route::get('/createbiblicalcitation', [BiblicalCitationController::class, 
                'admin_biblical_citation_create'])->name('admin.biblical.citation.create');
    Route::post('/storebiblicalcitation', [BiblicalCitationController::class, 
                'admin_biblical_citation_store'])->name('admin.biblical.citation.store');
    Route::get('/showbiblicalcitation/{id}', [BiblicalCitationController::class, 
                'admin_biblical_citation_show'])->name('admin.biblical.citation.show_details');
    Route::post('/updatebiblicalcitation', [BiblicalCitationController::class, 
                'admin_biblical_citation_update'])->name('admin.biblical.citation.update');   
    Route::post('/deletebiblicalcitation', [BiblicalCitationController::class, 
                'admin_biblical_citation_delete'])->name('admin.biblical.citation.delete');
    Route::get('/importbiblicalcitation', [BiblicalCitationController::class, 
            'admin_biblical_citation_import'])->name('admin.biblicalcitation.import');
    Route::post('import/progress/biblicalcitation'  ,[BiblicalCitationController::class,
            'import_progress_biblical_citation'])->name('import.progress.biblical.citation');
    Route::post('/storebiblicalcitationimport', [BiblicalCitationController::class, 
                'admin_biblical_citation_import_store'])->name('admin.biblical.citation.Import.store');

    Route::get('/memorieslist', [MemoriesController::class, 'admin_memories_list'])
            ->name('admin.memories.list');
    Route::get('/memoriesDatatable',[MemoriesController::class,'admin_memories_Datatable'])
            ->name('admin.memories.list.datatable');
    Route::get('/creatememories', [MemoriesController::class, 'admin_memories_create'])
            ->name('admin.memories.create');
    Route::post('/storememories', [MemoriesController::class, 'admin_memories_store'])
            ->name('admin.memories.store');
    Route::get('/showmemory/{id}', [MemoriesController::class, 'admin_memories_show'])
            ->name('admin.memories.show_details');
    Route::post('/updatememory', [MemoriesController::class, 'admin_memories_update'])
            ->name('admin.memories.update');   
    Route::post('/deletememory', [MemoriesController::class, 'admin_memories_delete'])
            ->name('admin.memories.delete');

    Route::get('/dailyscheduleslist', [DailyScheduleController::class, 'admin_daily_schedules_list'])
            ->name('admin.daily.schedules.list');
    Route::get('/dailyschedulesDatatable',[DailyScheduleController::class,'admin_daily_schedules_Datatable'])
            ->name('admin.daily.schedules.datatable');
    Route::get('/createdailyschedule', [DailyScheduleController::class, 'admin_daily_schedules_create'])
            ->name('admin.daily.schedules.create');
    Route::post('/storedailyschedule', [DailyScheduleController::class, 'admin_daily_schedules_store'])
            ->name('admin.daily.schedules.store');
    Route::get('/showdailyschedule/{id}', [DailyScheduleController::class, 'admin_daily_schedules_show'])
            ->name('admin.daily.schedules.show_details');
    Route::post('/updatedailyschedule', [DailyScheduleController::class, 'admin_daily_schedules_update'])
            ->name('admin.daily.schedules.update');   
    Route::post('/deletedailyschedule', [DailyScheduleController::class, 'admin_daily_schedules_delete'])
            ->name('admin.daily.schedules.delete');
  
    Route::post('/deleteImage', [HomeController::class, 'admin_delete_image'])
            ->name('admin.delete.image');
});














    Route::view('index', 'dashboard.index')->name('index');
    Route::view('dashboard-02', 'dashboard.dashboard-02')->name('dashboard-02');
    Route::view('dashboard-03', 'dashboard.dashboard-03')->name('dashboard-03');
    Route::view('dashboard-04', 'dashboard.dashboard-04')->name('dashboard-04');
    Route::view('dashboard-05', 'dashboard.dashboard-05')->name('dashboard-05');
    Route::view('general-widget', 'widgets.general-widget')->name('general-widget');
    Route::view('chart-widget', 'widgets.chart-widget')->name('chart-widget');
    Route::view('box-layout', 'page-layout.box-layout')->name('box-layout');
    Route::view('layout-rtl', 'page-layout.layout-rtl')->name('layout-rtl');
    Route::view('layout-dark', 'page-layout.layout-dark')->name('layout-dark');
    Route::view('hide-on-scroll', 'page-layout.hide-on-scroll')->name('hide-on-scroll');
    Route::view('footer-light', 'page-layout.footer-light')->name('footer-light');
    Route::view('footer-dark', 'page-layout.footer-dark')->name('footer-dark');
    Route::view('footer-fixed', 'page-layout.footer-fixed')->name('footer-fixed');
    Route::view('projects', 'project.projects')->name('projects');
    Route::view('projectcreate', 'project.projectcreate')->name('projectcreate');
    Route::view('file-manager', 'file-manager')->name('file-manager');
    Route::view('kanban', 'kanban')->name('kanban');
    Route::view('product', 'apps.product')->name('product');
    Route::view('page-product', 'apps.product-page')->name('product-page');
    Route::view('list-products', 'apps.list-products')->name('list-products');
    Route::view('payment-details', 'apps.payment-details')->name('payment-details');
    Route::view('order-history', 'apps.order-history')->name('order-history');
    Route::view('invoice-template', 'apps.invoice-template')->name('invoice-template');
    Route::view('cart', 'apps.cart')->name('cart');
    Route::view('list-wish', 'apps.list-wish')->name('list-wish');
    Route::view('checkout', 'apps.checkout')->name('checkout');
    Route::view('pricing', 'apps.pricing')->name('pricing');
    Route::view('email-application', 'apps.email-application')->name('email-application');
    Route::view('email-compose', 'apps.email-compose')->name('email-compose');
    Route::view('chat', 'apps.chat')->name('chat');
    Route::view('video-chat', 'apps.video-chat')->name('chat-video');
    Route::view('user-profile', 'apps.user-profile')->name('user-profile');
    Route::view('edit-profile', 'apps.edit-profile')->name('edit-profile');
    Route::view('user-cards', 'apps.user-cards')->name('user-cards');
    Route::view('bookmark', 'apps.bookmark')->name('bookmark');
    Route::view('contacts', 'apps.contacts')->name('contacts');
    Route::view('task', 'apps.task')->name('task');
    Route::view('calendar-basic', 'apps.calendar-basic')->name('calendar-basic');
    Route::view('social-app', 'apps.social-app')->name('social-app');
    Route::view('to-do', 'apps.to-do')->name('to-do');
    Route::view('search', 'apps.search')->name('search');
    Route::view('state-color', 'ui-kits.state-color')->name('state-color');
    Route::view('typography', 'ui-kits.typography')->name('typography');
    Route::view('avatars', 'ui-kits.avatars')->name('avatars');
    Route::view('helper-classes', 'ui-kits.helper-classes')->name('helper-classes');
    Route::view('grid', 'ui-kits.grid')->name('grid');
    Route::view('tag-pills', 'ui-kits.tag-pills')->name('tag-pills');
    Route::view('progress-bar', 'ui-kits.progress-bar')->name('progress-bar');
    Route::view('modal', 'ui-kits.modal')->name('modal');
    Route::view('alert', 'ui-kits.alert')->name('alert');
    Route::view('popover', 'ui-kits.popover')->name('popover');
    Route::view('tooltip', 'ui-kits.tooltip')->name('tooltip');
    Route::view('loader', 'ui-kits.loader')->name('loader');
    Route::view('dropdown', 'ui-kits.dropdown')->name('dropdown');
    Route::view('accordion', 'ui-kits.accordion')->name('accordion');
    Route::view('tab-bootstrap', 'ui-kits.tab-bootstrap')->name('tab-bootstrap');
    Route::view('tab-material', 'ui-kits.tab-material')->name('tab-material');
    Route::view('box-shadow', 'ui-kits.box-shadow')->name('box-shadow');
    Route::view('list', 'ui-kits.list')->name('list');

    Route::view('scrollable', 'bonus-ui.scrollable')->name('scrollable');
    Route::view('tree', 'bonus-ui.tree')->name('tree');
    Route::view('bootstrap-notify', 'bonus-ui.bootstrap-notify')->name('bootstrap-notify');
    Route::view('rating', 'bonus-ui.rating')->name('rating');
    Route::view('dropzone', 'bonus-ui.dropzone')->name('dropzone');
    Route::view('tour', 'bonus-ui.tour')->name('tour');
    Route::view('sweet-alert2', 'bonus-ui.sweet-alert2')->name('sweet-alert2');
    Route::view('modal-animated', 'bonus-ui.modal-animated')->name('modal-animated');
    Route::view('owl-carousel', 'bonus-ui.owl-carousel')->name('owl-carousel');
    Route::view('ribbons', 'bonus-ui.ribbons')->name('ribbons');
    Route::view('pagination', 'bonus-ui.pagination')->name('pagination');
    Route::view('breadcrumb', 'bonus-ui.breadcrumb')->name('breadcrumb');
    Route::view('range-slider', 'bonus-ui.range-slider')->name('range-slider');
    Route::view('image-cropper', 'bonus-ui.image-cropper')->name('image-cropper');
    Route::view('sticky', 'bonus-ui.sticky')->name('sticky');
    Route::view('basic-card', 'bonus-ui.basic-card')->name('basic-card');
    Route::view('creative-card', 'bonus-ui.creative-card')->name('creative-card');
    Route::view('tabbed-card', 'bonus-ui.tabbed-card')->name('tabbed-card');
    Route::view('dragable-card', 'bonus-ui.dragable-card')->name('dragable-card');
    Route::view('timeline-v-1', 'bonus-ui.timeline-v-1')->name('timeline-v-1');
    Route::view('timeline-v-2', 'bonus-ui.timeline-v-2')->name('timeline-v-2');
    Route::view('timeline-small', 'bonus-ui.timeline-small')->name('timeline-small');

    Route::view('form-builder-1', 'builders.form-builder-1')->name('form-builder-1');
    Route::view('form-builder-2', 'builders.form-builder-2')->name('form-builder-2');
    Route::view('pagebuild', 'builders.pagebuild')->name('pagebuild');
    Route::view('button-builder', 'builders.button-builder')->name('button-builder');

    Route::view('animate', 'animation.animate')->name('animate');
    Route::view('scroll-reval', 'animation.scroll-reval')->name('scroll-reval');
    Route::view('aos', 'animation.aos')->name('aos');
    Route::view('tilt', 'animation.tilt')->name('tilt');
    Route::view('wow', 'animation.wow')->name('wow');

    Route::view('flag-icon', 'icons.flag-icon')->name('flag-icon');
    Route::view('font-awesome', 'icons.font-awesome')->name('font-awesome');
    Route::view('ico-icon', 'icons.ico-icon')->name('ico-icon');
    Route::view('themify-icon', 'icons.themify-icon')->name('themify-icon');
    Route::view('feather-icon', 'icons.feather-icon')->name('feather-icon');
    Route::view('whether-icon', 'icons.whether-icon')->name('whether-icon');
    Route::view('simple-line-icon', 'icons.simple-line-icon')->name('simple-line-icon');
    Route::view('material-design-icon', 'icons.material-design-icon')->name('material-design-icon');
    Route::view('pe7-icon', 'icons.pe7-icon')->name('pe7-icon');
    Route::view('typicons-icon', 'icons.typicons-icon')->name('typicons-icon');
    Route::view('ionic-icon', 'icons.ionic-icon')->name('ionic-icon');

    Route::view('buttons', 'buttons.buttons')->name('buttons');
    Route::view('flat-buttons', 'buttons.flat-buttons')->name('flat-buttons');
    Route::view('edge-buttons', 'buttons.buttons-edge')->name('buttons-edge');
    Route::view('raised-button', 'buttons.raised-button')->name('raised-button');
    Route::view('button-group', 'buttons.button-group')->name('button-group');

    Route::view('form-validation', 'forms.form-validation')->name('form-validation');
    Route::view('base-input', 'forms.base-input')->name('base-input');
    Route::view('radio-checkbox-control', 'forms.radio-checkbox-control')->name('radio-checkbox-control');
    Route::view('input-group', 'forms.input-group')->name('input-group');
    Route::view('megaoptions', 'forms.megaoptions')->name('megaoptions');
    Route::view('datepicker', 'forms.datepicker')->name('datepicker');
    Route::view('time-picker', 'forms.time-picker')->name('time-picker');
    Route::view('datetimepicker', 'forms.datetimepicker')->name('datetimepicker');
    Route::view('daterangepicker', 'forms.daterangepicker')->name('daterangepicker');
    Route::view('touchspin', 'forms.touchspin')->name('touchspin');
    Route::view('select2', 'forms.select2')->name('select2');
    Route::view('switch', 'forms.switch')->name('switch');
    Route::view('typeahead', 'forms.typeahead')->name('typeahead');
    Route::view('clipboard', 'forms.clipboard')->name('clipboard');
    Route::view('default-form', 'forms.default-form')->name('default-form');
    Route::view('form-wizard', 'forms.form-wizard')->name('form-wizard');
    Route::view('form-two-wizard', 'forms.form-wizard-two')->name('form-wizard-two');
    Route::view('wizard-form-three', 'forms.form-wizard-three')->name('form-wizard-three');
    Route::post('form-wizard-three', function () {
        return redirect()->route('form-wizard-three');
    })->name('form-wizard-three-post');

    Route::view('bootstrap-basic-table', 'tables.bootstrap-basic-table')->name('bootstrap-basic-table');
    Route::view('bootstrap-sizing-table', 'tables.bootstrap-sizing-table')->name('bootstrap-sizing-table');
    Route::view('bootstrap-border-table', 'tables.bootstrap-border-table')->name('bootstrap-border-table');
    Route::view('bootstrap-styling-table', 'tables.bootstrap-styling-table')->name('bootstrap-styling-table');
    Route::view('table-components', 'tables.table-components')->name('table-components');
    Route::view('datatable-basic-init', 'tables.datatable-basic-init')->name('datatable-basic-init');
    Route::view('datatable-advance', 'tables.datatable-advance')->name('datatable-advance');
    Route::view('datatable-styling', 'tables.datatable-styling')->name('datatable-styling');
    Route::view('datatable-ajax', 'tables.datatable-ajax')->name('datatable-ajax');
    Route::view('datatable-server-side', 'tables.datatable-server-side')->name('datatable-server-side');
    Route::view('datatable-plugin', 'tables.datatable-plugin')->name('datatable-plugin');
    Route::view('datatable-api', 'tables.datatable-api')->name('datatable-api');
    Route::view('datatable-data-source', 'tables.datatable-data-source')->name('datatable-data-source');
    Route::view('datatable-ext-autofill', 'tables.datatable-ext-autofill')->name('datatable-ext-autofill');
    Route::view('datatable-ext-basic-button', 'tables.datatable-ext-basic-button')->name('datatable-ext-basic-button');
    Route::view('datatable-ext-col-reorder', 'tables.datatable-ext-col-reorder')->name('datatable-ext-col-reorder');
    Route::view('datatable-ext-fixed-header', 'tables.datatable-ext-fixed-header')->name('datatable-ext-fixed-header');
    Route::view('datatable-ext-html-5-data-export', 'tables.datatable-ext-html-5-data-export')->name('datatable-ext-html-5-data-export');
    Route::view('datatable-ext-key-table', 'tables.datatable-ext-key-table')->name('datatable-ext-key-table');
    Route::view('datatable-ext-responsive', 'tables.datatable-ext-responsive')->name('datatable-ext-responsive');
    Route::view('datatable-ext-row-reorder', 'tables.datatable-ext-row-reorder')->name('datatable-ext-row-reorder');
    Route::view('datatable-ext-scroller', 'tables.datatable-ext-scroller')->name('datatable-ext-scroller');
    Route::view('jsgrid-table', 'tables.jsgrid-table')->name('jsgrid-table');

    Route::view('echarts', 'charts.echarts')->name('echarts');
    Route::view('chart-apex', 'charts.chart-apex')->name('chart-apex');
    Route::view('chart-google', 'charts.chart-google')->name('chart-google');
    Route::view('chart-sparkline', 'charts.chart-sparkline')->name('chart-sparkline');
    Route::view('chart-flot', 'charts.chart-flot')->name('chart-flot');
    Route::view('chart-knob', 'charts.chart-knob')->name('chart-knob');
    Route::view('chart-morris', 'charts.chart-morris')->name('chart-morris');
    Route::view('chartjs', 'charts.chartjs')->name('chartjs');
    Route::view('chartist', 'charts.chartist')->name('chartist');
    Route::view('chart-peity', 'charts.chart-peity')->name('chart-peity');

    Route::view('sample-page', 'pages.sample-page')->name('sample-page');
    Route::view('internationalization', 'pages.internationalization')->name('internationalization');


    Route::view('400', 'errors.400')->name('error-400');
    Route::view('401', 'errors.401')->name('error-401');
    Route::view('403', 'errors.403')->name('error-403');
    Route::view('404', 'errors.404')->name('error-404');
    Route::view('500', 'errors.500')->name('error-500');
    Route::view('503', 'errors.503')->name('error-503');

    Route::view('login', 'authentication.login')->name('login');
    Route::view('login-one', 'authentication.login-one')->name('login-one');
    Route::view('login-two', 'authentication.login-two')->name('login-two');
    Route::view('login-bs-validation', 'authentication.login-bs-validation')->name('login-bs-validation');
    Route::view('login-bs-tt-validation', 'authentication.login-bs-tt-validation')->name('login-bs-tt-validation');
    Route::view('login-sa-validation', 'authentication.login-sa-validation')->name('login-sa-validation');
    Route::view('sign-up', 'authentication.sign-up')->name('sign-up');
    Route::view('sign-up-one', 'authentication.sign-up-one')->name('sign-up-one');
    Route::view('sign-up-two', 'authentication.sign-up-two')->name('sign-up-two');
    Route::view('sign-up-wizard', 'authentication.sign-up-wizard')->name('sign-up-wizard');
    Route::view('unlock', 'authentication.unlock')->name('unlock');
    Route::view('forget-password', 'authentication.forget-password')->name('forget-password');
    Route::view('reset-password', 'authentication.reset-password')->name('reset-password');
    Route::view('maintenance', 'authentication.maintenance')->name('maintenance');

    Route::view('comingsoon-bg-video', 'comingsoon.comingsoon-bg-video')->name('comingsoon-bg-video');
    Route::view('comingsoon-bg-img', 'comingsoon.comingsoon-bg-img')->name('comingsoon-bg-img');

    Route::view('basic-template', 'email-templates.basic-template')->name('basic-template');
    Route::view('email-header', 'email-templates.email-header')->name('email-header');
    Route::view('template-email', 'email-templates.template-email')->name('template-email');
    Route::view('template-email-2', 'email-templates.template-email-2')->name('template-email-2');
    Route::view('ecommerce-templates', 'email-templates.ecommerce-templates')->name('ecommerce-templates');
    Route::view('email-order-success', 'email-templates.email-order-success')->name('email-order-success');



    Route::view('index', 'apps.gallery')->name('gallery');
    Route::view('with-gallery-description', 'apps.gallery-with-description')->name('gallery-with-description');
    Route::view('gallery-masonry', 'apps.gallery-masonry')->name('gallery-masonry');
    Route::view('masonry-gallery-with-disc', 'apps.masonry-gallery-with-disc')->name('masonry-gallery-with-disc');
    Route::view('gallery-hover', 'apps.gallery-hover')->name('gallery-hover');

    Route::view('index', 'apps.blog')->name('blog');
    Route::view('blog-single', 'apps.blog-single')->name('blog-single');
    Route::view('add-post', 'apps.add-post')->name('add-post');

    Route::view('faq', 'apps.faq')->name('faq');


    Route::view('job-cards-view', 'apps.job-cards-view')->name('job-cards-view');
    Route::view('job-list-view', 'apps.job-list-view')->name('job-list-view');
    Route::view('job-details', 'apps.job-details')->name('job-details');
    Route::view('job-apply', 'apps.job-apply')->name('job-apply');

    Route::view('learning-list-view', 'apps.learning-list-view')->name('learning-list-view');
    Route::view('learning-detailed', 'apps.learning-detailed')->name('learning-detailed');

    Route::view('map-js', 'apps.map-js')->name('map-js');
    Route::view('vector-map', 'apps.vector-map')->name('vector-map');

    Route::view('summernote', 'apps.summernote')->name('summernote');
    Route::view('ckeditor', 'apps.ckeditor')->name('ckeditor');
    Route::view('simple-mde', 'apps.simple-mde')->name('simple-mde');
    Route::view('ace-code-editor', 'apps.ace-code-editor')->name('ace-code-editor');

    Route::view('knowledgebase', 'apps.knowledgebase')->name('knowledgebase');
    Route::view('support-ticket', 'apps.support-ticket')->name('support-ticket');
    Route::view('landing-page', 'pages.landing-page')->name('landing-page');


    Route::view('compact-sidebar', 'admin_unique_layouts.compact-sidebar'); //default //Dubai
    Route::view('box-layout', 'admin_unique_layouts.box-layout');    //default //New York //
    Route::view('dark-sidebar', 'admin_unique_layouts.dark-sidebar');

    Route::view('default-body', 'admin_unique_layouts.default-body');
    Route::view('compact-wrap', 'admin_unique_layouts.compact-wrap');
    Route::view('enterprice-type', 'admin_unique_layouts.enterprice-type');

    Route::view('compact-small', 'admin_unique_layouts.compact-small');
    Route::view('advance-type', 'admin_unique_layouts.advance-type');
    Route::view('material-layout', 'admin_unique_layouts.material-layout');

    Route::view('color-sidebar', 'admin_unique_layouts.color-sidebar');
    Route::view('material-icon', 'admin_unique_layouts.material-icon');
    Route::view('modern-layout', 'admin_unique_layouts.modern-layout');

    Route::get('layout-{light}', function ($light) {
        session()->put('layout', $light);
        session()->get('layout');
        if ($light == 'vertical-layout') {
            return redirect()->route('pages-vertical-layout');
        }
        return redirect()->route('index');
        return 1;
    });

    Route::get('/clear-cache', function () {
        Artisan::call('config:cache');
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        return "Cache is cleared";
    })->name('clear.cache');

