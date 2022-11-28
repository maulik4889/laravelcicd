<?php
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/phpinfo', function () {
    return phpinfo();
});

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::namespace ('FRONTEND')->group(function () {
    Route::get('verification/{key}', ['uses' => 'UsersController@verifyUser']); # verify user on click email template
    Route::get('/reset-password/{token}', ['uses' => 'UsersController@showResetForm']); #show reset form on web
    Route::post('resetPassword', ['uses' => 'UsersController@resetPassword']); # user reset password
});

Route::post('test', function () {
    return 'Post is working';
});

# Admin Panel
// admin login route
Route::post('login', ['as' => 'postmethod.login', 'uses' => 'Auth\LoginController@login'])->middleware('checkLogin');
Route::get('/pages/{version}/{slug}', ['as' => 'getpage.pages', 'uses' => 'Admin\PagesController@getPageData'])->middleware('checkLogin');
// resend verification email
Route::get('user/resendVerify/{email}', ['as' => 'resend.verify', 'uses' => 'Auth\RegisterController@resendUserVerification'])->middleware('checkLogin');

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::group(['middleware' => ['auth', 'admin']], function () {

        Route::group(['middleware' => ['auth']], function () {
            Route::get('/getDownload/{id}', ['as' => 'admin.getdownload', 'uses' => 'UsersController@getDownload']);

            // route for show dashboard data
            Route::get('/', ['as' => 'admin.dashboard', 'uses' => 'UsersController@dashboard']);

            // route for show daily classes reports
            Route::get('/reports/{id}', ['as' => 'admin.reports', 'uses' => 'PaymentsController@reports']);

            // route for show daily logins
            Route::get('/logins/{id}', ['as' => 'admin.logins', 'uses' => 'PaymentsController@logins']);
            Route::get('/filter/{id}', ['as' => 'users.filter', 'uses' => 'UsersController@signupFilter']);
            Route::get('/filterusers/{id}', ['as' => 'users-students.filter', 'uses' => 'UsersController@signupFilterUser']);

            // route for show daily classes requests
            Route::get('/requests/{id}', ['as' => 'admin.requests', 'uses' => 'PaymentsController@requests']);

            // route for show daily classes requests
            Route::get('/deletedUsersList', ['as' => 'admin.deletedUsersList', 'uses' => 'PaymentsController@deletedUsersList']);
            

            // route for show daily new users on the platform
            Route::get('/newUsers/{id}', ['as' => 'admin.newUsers', 'uses' => 'PaymentsController@newUsers']);

            // route for download excel file of daily classes reportd
            Route::get('/dailyreport/{id}', ['as' => 'admin.dailyreport', 'uses' => 'PaymentsController@dailyReport']);
            Route::get('/dailyreports', ['as' => 'admin.dailyreports', 'uses' => 'PaymentsController@dailyReports']);

            // route for download excel file of daily users
            Route::get('/dailyvisitors/{id}', ['as' => 'admin.dailyvisitors', 'uses' => 'PaymentsController@dailyVisitors']);

            // route for download excel file of daily logins
            Route::get('/dailylogins/{id}', ['as' => 'admin.dailylogins', 'uses' => 'PaymentsController@dailyLogins']);

            // route for download excel file of daily class requests
            Route::get('/dailyrequests/{id}', ['as' => 'admin.dailyrequests', 'uses' => 'PaymentsController@dailyRequests']);

            // route for download excel file of deleted users
            Route::get('/deletedUsers', ['as' => 'admin.deletedUsers', 'uses' => 'PaymentsController@deletedUsers']);

            // route for get search terms on the platform
            Route::get('/getSearchItems/{id}', ['as' => 'admin.getsearchitems', 'uses' => 'UsersController@getSearchItems']);

            // route for filter search terms data weekly
            

            Route::post('/filterSearchWeekly', ['as' => 'admin.search_terms.weekly', 'uses' => 'UsersController@filterSearchWeekly']);

            // route for show change password page
            Route::get('/getChangePassword', ['as' => 'admin.getchange.password', 'uses' => 'UsersController@getChangePassword']);

            // route for submit change password details
            Route::post('/getChangePassword', ['as' => 'admin.postchange.password', 'uses' => 'UsersController@postChangePassword']);

            // routes for manage hosts and users details

            Route::group(['prefix' => 'manageUsers'], function () {
                Route::get('/filter/{id}', ['as' => 'admin.users.list', 'uses' => 'UsersController@getList']);

                Route::post('/confirmPassword', ['as' => 'admin.confirmPassword', 'uses' => 'UsersController@confirmPassword']);

                Route::post('/confirmPasswordForDelete', ['as' => 'admin.confirmPasswordForDelete', 'uses' => 'UsersController@confirmPasswordForDelete']);
                

                Route::get('/students', ['as' => 'admin.students.list', 'uses' => 'UsersController@getStudentList']);

                Route::get('/delete', ['as' => 'admin.users.delete', 'uses' => 'UsersController@delete']);

                Route::get('/students/delete', ['as' => 'admin.users.delete', 'uses' => 'UsersController@delete']);

                Route::get('/status', ['as' => 'admin.users.status', 'uses' => 'UsersController@status']);

                Route::get('/students/status', ['as' => 'admin.users.status', 'uses' => 'UsersController@status']);

                Route::get('/verifyUserPost', ['as' => 'admin.users.verifyPost', 'uses' => 'UsersController@verifyUserPost']);

                Route::get('/emailStatus', ['as' => 'admin.users.emailStatus', 'uses' => 'UsersController@emailStatus']);

                Route::get('/{id}', ['as' => 'admin.user.detail', 'uses' => 'UsersController@getUserDetail']);
                
                Route::get('/hideProfile/{id}', ['as' => 'admin.hideprofile', 'uses' => 'UsersController@hideUnhideProfile']);
                Route::get('/status', ['as' => 'admin.users.status', 'uses' => 'UsersController@status']);
                Route::post('/markAsFeatured', ['as' => 'admin.markAsFeatured', 'uses' => 'UsersController@markAsFeatured']);
                Route::get('/removeFromFeatured/{id}', ['as' => 'admin.removeFromFeatured', 'uses' => 'UsersController@removeFromFeatured']);
                
            });

            // routes for manage reported users
            Route::group(['prefix' => 'manageReportedUsers'], function () {
                Route::get('/', ['as' => 'admin.reportedusers.list', 'uses' => 'UsersController@reportUserList']);
                Route::get('/{id}', ['as' => 'admin.reportedusers.detail', 'uses' => 'UsersController@reportUserDetail']);
            });

            // routes for mange manual emails
            Route::group(['prefix' => 'manageEmails'], function () {
                Route::get('/getEmailForm', ['as' => 'admin.email.send', 'uses' => 'UsersController@getEmailForm']);
                Route::post('/postEmails', ['as' => 'admin.email.post', 'uses' => 'UsersController@postEmails']);
            });

            // routes for pages management tab in admin panel 
            Route::group(['prefix' => 'managePages'], function () {
                Route::get('/', ['as' => 'admin.pages.get', 'uses' => 'PagesController@getList']);
                Route::get('/add', ['as' => 'admin.pages.getadd', 'uses' => 'PagesController@getAdd']);
                Route::post('/', ['as' => 'admin.pages.postadd', 'uses' => 'PagesController@postAdd']);
                Route::get('/edit/{id}', ['as' => 'admin.pages.getedit', 'uses' => 'PagesController@getEdit']);
                Route::post('/edit/{id}', ['as' => 'admin.pages.postedit', 'uses' => 'PagesController@postEdit']);
                Route::get('/delete', ['as' => 'admin.pages.delete', 'uses' => 'PagesController@delete']);

                Route::get('/status', ['as' => 'admin.pages.status', 'uses' => 'PagesController@status']);
            });

            // routes for category 
            Route::group(['prefix' => 'manageCategory'], function () {
                Route::get('/', ['as' => 'admin.category.get', 'uses' => 'CategoryController@getList']);
                Route::get('/add', ['as' => 'admin.category.getadd', 'uses' => 'CategoryController@getAdd']);
                Route::post('/', ['as' => 'admin.category.postadd', 'uses' => 'CategoryController@postAdd']);
                Route::get('/edit/{id}', ['as' => 'admin.category.getedit', 'uses' => 'CategoryController@getEdit']);
                Route::post('/edit/{id}', ['as' => 'admin.category.postedit', 'uses' => 'CategoryController@postEdit']);
                //Route::get('/delete', ['as' => 'admin.category.delete', 'uses' => 'CategoryController@delete']);

                Route::get('/status', ['as' => 'admin.category.status', 'uses' => 'CategoryController@status']);
            });

             // routes for category 
             Route::group(['prefix' => 'manageBlogs'], function () {
                Route::get('/', ['as' => 'admin.blogs.get', 'uses' => 'BlogsController@getList']);
                Route::get('/add', ['as' => 'admin.blogs.getadd', 'uses' => 'BlogsController@getAdd']);
                Route::post('/', ['as' => 'admin.blogs.postadd', 'uses' => 'BlogsController@postAdd']);
                Route::get('/edit/{id}', ['as' => 'admin.blogs.getedit', 'uses' => 'BlogsController@getEdit']);
                Route::post('/edit/{id}', ['as' => 'admin.blogs.postedit', 'uses' => 'BlogsController@postEdit']);
                //Route::get('/delete', ['as' => 'admin.category.delete', 'uses' => 'CategoryController@delete']);

                Route::get('/status', ['as' => 'admin.blogs.status', 'uses' => 'BlogsController@status']);
            });

           // routes for category 
           Route::group(['prefix' => 'manageNews'], function () {
            Route::get('/', ['as' => 'admin.news.get', 'uses' => 'NewsController@getList']);
            Route::get('/add', ['as' => 'admin.news.getadd', 'uses' => 'NewsController@getAdd']);
            Route::post('/', ['as' => 'admin.news.postadd', 'uses' => 'NewsController@postAdd']);
            Route::get('/edit/{id}', ['as' => 'admin.news.getedit', 'uses' => 'NewsController@getEdit']);
            Route::post('/edit/{id}', ['as' => 'admin.news.postedit', 'uses' => 'NewsController@postEdit']);
            //Route::get('/delete', ['as' => 'admin.category.delete', 'uses' => 'CategoryController@delete']);

            Route::get('/status', ['as' => 'admin.news.status', 'uses' => 'NewsController@status']);
        });

            // routes of reported posts details
            Route::group(['prefix' => 'manageReportedPosts'], function () {
                Route::get('/', ['as' => 'admin.reportedposts.list', 'uses' => 'ReportPostController@reportPostList']);
                Route::get('/{id}', ['as' => 'admin.reportedposts.detail', 'uses' => 'ReportPostController@reportPostDetail']);

            });

            // routes of subjects
            Route::group(['prefix' => 'manageSubject'], function () {
                Route::get('/', ['as' => 'admin.subject.get', 'uses' => 'SubjectController@getList']);
                Route::get('/add', ['as' => 'admin.subject.getadd', 'uses' => 'SubjectController@getAdd']);
                Route::post('/', ['as' => 'admin.subject.postadd', 'uses' => 'SubjectController@postAdd']);
                Route::get('/edit/{id}', ['as' => 'admin.subject.getedit', 'uses' => 'SubjectController@getEdit']);
                Route::post('/edit/{id}', ['as' => 'admin.subject.postedit', 'uses' => 'SubjectController@postEdit']);
                //Route::get('/delete', ['as' => 'admin.category.delete', 'uses' => 'CategoryController@delete']);

                Route::get('/status', ['as' => 'admin.subject.status', 'uses' => 'SubjectController@status']);
            });

            // routes of skills
            Route::group(['prefix' => 'manageSkill'], function () {
                Route::get('/', ['as' => 'admin.skill.get', 'uses' => 'SkillsController@getList']);
                Route::get('/add', ['as' => 'admin.skill.getadd', 'uses' => 'SkillsController@getAdd']);
                Route::post('/', ['as' => 'admin.skill.postadd', 'uses' => 'SkillsController@postAdd']);
                Route::get('/edit/{id}', ['as' => 'admin.skill.getedit', 'uses' => 'SkillsController@getEdit']);
                Route::post('/edit/{id}', ['as' => 'admin.skill.postedit', 'uses' => 'SkillsController@postEdit']);
                //Route::get('/delete', ['as' => 'admin.category.delete', 'uses' => 'CategoryController@delete']);

                Route::get('/status', ['as' => 'admin.skill.status', 'uses' => 'SkillsController@status']);
            });

            //Routes of faqs 
            Route::group(['prefix' => 'manageFaqs'], function () {
                Route::get('/', ['as' => 'admin.faq.get', 'uses' => 'FaqsController@getList']);
                Route::get('/add', ['as' => 'admin.faq.getadd', 'uses' => 'FaqsController@getAdd']);
                Route::post('/', ['as' => 'admin.faq.postadd', 'uses' => 'FaqsController@postAdd']);
                Route::get('/edit/{id}', ['as' => 'admin.faq.getedit', 'uses' => 'FaqsController@getEdit']);
                Route::post('/edit/{id}', ['as' => 'admin.faq.postedit', 'uses' => 'FaqsController@postEdit']);
                //Route::get('/delete', ['as' => 'admin.category.delete', 'uses' => 'CategoryController@delete']);

                Route::get('/status', ['as' => 'admin.faq.status', 'uses' => 'FaqsController@status']);
            });

            // route for when admin activate/deactivate reported post
            Route::get('reportedPosts/status', ['as' => 'admin.reportedposts.status', 'uses' => 'ReportPostController@status']);

            Route::group(['prefix' => 'managePayments'], function () {

                // get payments based on classes route
                Route::get('/{id}', ['as' => 'admin.payments.list', 'uses' => 'PaymentsController@getList']);

                // get payments based on subscriptions route
                Route::get('/subscriptions/{id}', ['as' => 'admin.subscriptions.list', 'uses' => 'PaymentsController@getListSubscriptions']);

            //route for download payments record in excel file
                Route::get('/excel/{id}', ['as' => 'admin.excel.list', 'uses' => 'PaymentsController@excel']);
            //route for download coupons record in excel file

                Route::get('/couponexcel/{id}', ['as' => 'admin.couponexcel.list', 'uses' => 'PaymentsController@couponExcel']);

             //route for single  payment record 

                Route::get('/payment_detail/{id}', ['as' => 'admin.payment.detail', 'uses' => 'PaymentsController@getPaymentDetail']);
            });
       
            //Coupon controllers routes
            Route::group(['prefix' => 'manageCoupons'], function () {
                Route::get('/', ['as' => 'admin.coupons.get', 'uses' => 'CouponController@getList']);
                Route::get('/add', ['as' => 'admin.coupon.getadd', 'uses' => 'CouponController@getAdd']);
                Route::post('/', ['as' => 'admin.coupon.postadd', 'uses' => 'CouponController@postAdd']);
                Route::get('/edit/{id}', ['as' => 'admin.coupon.getedit', 'uses' => 'CouponController@getEdit']);
                Route::post('/edit/{id}', ['as' => 'admin.coupon.postedit', 'uses' => 'CouponController@postEdit']);
                
                Route::get('/status', ['as' => 'admin.coupon.status', 'uses' => 'CouponController@status']);
            });

        });
    });
});
//stripe webhooks routes
Route::stripeWebhooks('myaccount/{configKey}');
Route::stripeWebhooks('connectedaccount/{configKey}');
