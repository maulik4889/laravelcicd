
<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::group(['middleware' => 'cors'], function () {
    // header('Access-Control-Allow-Origin: *');
    // header( 'Access-Control-Allow-Headers: Authorization, Content-Type' );
Route::group(['prefix' => 'user'], function () {


    Route::post('login', 'API\UsersController@login');
    Route::post('socialLogin', 'API\UsersController@socialLogin');
    Route::post('signUp', 'API\UsersController@signUp');
    Route::post('resendVerification', 'API\UsersController@resendVerification');
    Route::post('forgotPassword', 'API\UsersController@forgotPassword');
    Route::get('searchTeacher', 'API\HomeController@searchTeacher');
    Route::get('getFaqs', 'API\HomeController@getFaqs');
    Route::get('popularReviews', 'API\HomeController@popularReviews');
    Route::get('popularFeeds', 'API\HomeController@popularFeeds');
    Route::post('contactUs', 'API\SettingsController@contactUs');
    Route::post('requestNewSkills', 'API\HomeController@requestNewSkills');
    Route::post('submiteducation', 'API\TeachersController@submitEducationDetail');
    Route::get('getPages', 'API\SettingsController@getPages');
    Route::get('getCategories', 'API\LessonsController@getCategories');
    Route::get('getDynamicSkills', 'API\SettingsController@getDynamicSkills');
    Route::get('singleBookedLessonDetail', 'API\UsersController@singleBookedLessonDetail');
    Route::get('searchTeacherProfile', 'API\StudentsController@searchTeacherProfile');
    Route::post('trackSearchTerms', 'API\HomeController@trackSearchTerms');
    Route::get('getSearchNames', 'API\HomeController@getSearchNames');
    Route::post('notifyMe', 'API\HomeController@notifyMe');
    Route::get('creditBankAccount', 'API\SettingsController@creditBankAccount');

    Route::post('paypaltest', 'API\SettingsController@test');
    Route::get('getBlogs', 'API\HomeController@getBlogs');
    Route::get('blogDetail', 'API\HomeController@blogDetail');
    Route::get('getFeaturedHosts', 'API\HomeController@getFeaturedHosts');
    Route::post('verifyUser', 'API\UsersController@verifyUser');

    
    
    

    
    
});

Route::group(['prefix' => 'home'], function () {

    Route::post('bookingEnquiry', 'API\HomeController@bookingEnquiry');
    Route::get('getNeighnourhoods', 'API\HomeController@getNeighnourhoods');
    Route::post('bestNeighbours', 'API\HomeController@bestNeighbours');

    Route::post('checklist', 'API\HomeController@checklist');

    

});
Route::group(['prefix' => 'teacher'], function () {

    Route::get('getSubjectSkills', 'API\TeachersController@getSubjectSkills');

});

// Routing for frontend user
Route::group(['middleware' => ['auth:api', 'user_data']], function () {
    Route::group(['prefix' => 'admin'], function () {
        Route::get('dashboard', 'API\AdminController@dashboard');
        Route::get('dailyReport', 'API\AdminController@dailyReport');

    });
    Route::group(['prefix' => 'user'], function () {
        Route::post('logout', 'API\UsersController@logout');
        Route::post('changePassword', 'API\UsersController@changePassword');
        Route::post('reportUser', 'API\UsersController@reportUser');
        Route::post('uploadProfileImage', 'API\UsersController@uploadProfileImage');
        Route::post('updateProfile', 'API\UsersController@updateProfile');
        Route::post('saveProfile', 'API\UsersController@saveProfile');
        Route::get('getProfile', 'API\UsersController@getProfile');        Route::post('currentLogin', 'API\UsersController@currentLogin');

        Route::get('getNews', 'API\HomeController@getNews');

    });

    Route::group(['prefix' => 'settings'], function () {
        Route::post('settingsOnOff', 'API\SettingsController@settingsOnOff');
        Route::post('changeEmail', 'API\SettingsController@changeEmail');
        Route::post('changePassword', 'API\SettingsController@changePassword');
        Route::get('getNotification', 'API\SettingsController@getNotification');
        Route::post('addBank', 'API\SettingsController@providerAddBank');
        Route::get('getBankAccountDetails', 'API\SettingsController@getBankAccountDetails');
        Route::post('addCard', 'API\SettingsController@addCard');
        Route::post('deleteCard', 'API\SettingsController@deleteCard');
        Route::post('chooseDefaultCard', 'API\SettingsController@chooseDefaultCard');
        Route::post('userCards', 'API\SettingsController@userCards');
        Route::get('getHeaderNotification', 'API\SettingsController@getHeaderNotification');
        Route::get('getSingleAddress', 'API\SettingsController@getSingleAddress');
        Route::post('viewAllNotifications', 'API\SettingsController@viewAllNotifications');
        Route::post('expiredLessons', 'API\SettingsController@expiredLessons');
        Route::post('completedLessons', 'API\SettingsController@completedLessons');
        Route::post('createUsers', 'API\SettingsController@createUsers');
        Route::post('transfer', 'API\SettingsController@transfer');
        Route::post('updateBankDetail', 'API\SettingsController@updateBankDetail');
        Route::post('viewSpecificationNotification', 'API\SettingsController@viewSpecificationNotification');
        Route::post('payment', 'API\SettingsController@payment');
        Route::post('unreadMessage', 'API\SettingsController@unreadMessage');
        Route::post('updateUnreadCount', 'API\SettingsController@updateUnreadCount');
        Route::get('getNotiList', 'API\SettingsController@getNotiList');
        Route::get('getStates', 'API\SettingsController@getStates');
        Route::post('paymentSubscription', 'API\SettingsController@paymentSubscription');
        Route::post('confirmPaymentSubscription', 'API\SettingsController@confirmPaymentSubscription');
        Route::get('getCards', 'API\SettingsController@getCards');
        Route::get('getSubscriptionDetail', 'API\SettingsController@getSubscriptionDetail');
        Route::get('getInvoiceDetail', 'API\SettingsController@getInvoiceDetail');
        Route::post('refundSubscription', 'API\SettingsController@refundSubscription');
        Route::post('saveBankDraftDetails', 'API\SettingsController@providerAddBank1');
        Route::get('getBankDraftDetails', 'API\SettingsController@getBankDraftDetails');
        Route::post('addPaypalEmail', 'API\SettingsController@addPaypalEmail');
        
        Route::post('nonEuropianClassBooking', 'API\SettingsController@nonEuropianClassBooking');

        # Chat
        Route::get('getPersonalChat', 'API\ChatsController@getPersonalChat');
        Route::get('getInboxChat', 'API\ChatsController@getInboxChat');
        Route::post('deleteSpecificMessage', 'API\ChatsController@deleteSpecificMessage');
        Route::post('deleteChat', 'API\ChatsController@deleteChat');
        Route::post('sendMessage', 'API\ChatsController@sendMessage');
        Route::get('getReviews', 'API\SettingsController@getReviews');
        Route::get('getReviewById', 'API\SettingsController@getReviewById');
        Route::post('deleteAccount', 'API\SettingsController@deleteAccount');
        Route::post('deleteAccountt', 'API\SettingsController@deleteAccountt');
        Route::get('getReasons', 'API\SettingsController@getReasons');
        Route::post('confirmPayment', 'API\SettingsController@confirmPayment');
        Route::post('teacherCancelBooking', 'API\SettingsController@teacherCancelBooking');
        Route::get('getCountries', 'API\SettingsController@getCountries');
        Route::post('cancelSubscription', 'API\SettingsController@cancelSubscription');
        Route::get('getExistingMeetingDetails', 'API\SettingsController@getExistingMeetingDetails');

        
    });

    // blockunblock
    Route::group(['prefix' => 'blockunblock'], function () {

        Route::post('blockedUser', 'API\BlockUnblockController@blockedUser');
        Route::get('getBlockedUser', 'API\BlockUnblockController@getBlockedUser');
        Route::post('unblockedUser', 'API\BlockUnblockController@unblockedUser');

    });

    // report unreport user
    Route::group(['prefix' => 'reportUser'], function () {

        Route::post('reportUser', 'API\ReportUserController@reportUser');
        Route::get('getReportedUser', 'API\ReportUserController@getReportedUser');
        Route::post('unReportUser', 'API\ReportUserController@unReportUser');

    });

    Route::group(['prefix' => 'home'], function () {
 
        Route::get('getChecklistTasks', 'API\HomeController@getChecklistTasks');
        Route::post('addTaskToUserChecklist', 'API\HomeController@addTaskToUserChecklist');
        Route::get('getTaskPercentage', 'API\HomeController@getTaskPercentage');
        Route::get('getUserNonSelectedCheckList', 'API\HomeController@getUserNonSelectedCheckList');
        
        
    });



});
