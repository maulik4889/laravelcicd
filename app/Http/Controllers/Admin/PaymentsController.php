<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CouponsExport;
use App\Exports\DeletedExport;
use App\Exports\LoginsExport;
use App\Exports\PaymentsExport;
use App\Exports\ReportsExport;
use App\Exports\RequestsExport;
use App\Exports\UsersExport;
use App\Exports\DailyreportExport;

use App\Http\Controllers\Controller;
use App\Models\BookedLesson;
use App\Models\DailyReport;
use App\Models\BookingRequest;
use App\Models\DeletedUser;
use App\Models\Payment;
use App\Models\UserSubscription;
use App\User;
use Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;
use Request;
use Carbon;

class PaymentsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

    }

    /* get payment list */
    public function getList(Request $request, $id)
    {
        $users = '';
        $title = "Payment Management";
        $auth = Auth::user();

        $parameter = "";
        if ($id == 'all') {
            $payments = Payment::with(['student', 'teacher'])->
                orderBy('created_at', 'desc')->paginate(\Config::get('variable.admin_page_per_record'));
        }
        if ($id == 'today') {
            $payments = Payment::whereBetween('created_at', [strtotime('today'), time()])->with(['student', 'teacher'])->
                orderBy('created_at', 'desc')->paginate(\Config::get('variable.admin_page_per_record'));
        }
        if ($id == 'weekly') {
            $payments = Payment::whereBetween('created_at', [strtotime('last sunday midnight'), time()])->with(['student', 'teacher'])->
                orderBy('created_at', 'desc')->paginate(\Config::get('variable.admin_page_per_record'));

        }
        if ($id == 'monthly') {
            $this_month = strtotime(date('01-m-Y'));
            $payments = Payment::whereBetween('created_at', [$this_month, time()])->with(['student', 'teacher'])->
                orderBy('created_at', 'desc')->paginate(\Config::get('variable.admin_page_per_record'));
        }else{
            $this_month = strtotime(date('01-'.$id.'-Y'));

            if($id =='1' || $id =='3' || $id=='5'|| $id=='7' || $id =='8' ||$id=='10' || $id =='12'){
                $this_month_end = strtotime(date('31-'.$id.'-Y'));}
                if($id =='2'){
                    $this_month_end = strtotime(date('28-'.$id.'-Y'));}
   
                else{
                    $this_month_end = strtotime(date('30-'.$id.'-Y'));}

                    $payments = Payment::whereBetween('created_at', [$this_month,  $this_month_end ])->with(['student', 'teacher'])->
                orderBy('created_at', 'desc')->paginate(\Config::get('variable.admin_page_per_record'));
        }

        return view('admin.payments.payments', [
            'payments' => $payments->appends(request()->input('page')),
            'title' => $title,
        ]);

    }

    // Get list of subscriptions
    public function getListSubscriptions(Request $request, $id)
    {
        $users = '';
        $title = "Payment Management";
        $auth = Auth::user();

        $parameter = "";
        if ($id == 'all') {
            $payments = UserSubscription::with(['users'])->
                orderBy('created_at', 'desc')->paginate(\Config::get('variable.admin_page_per_record'));
        }

        return view('admin.payments.subscriptions', [
            'payments' => $payments->appends(request()->input('page')),
            'title' => $title,
        ]);

    }
    public function excel($id)
    {
        if ($id == 'all') {
            $paymentss = Payment::with(['student', 'teacher'])->
                orderBy('created_at', 'desc')->paginate(\Config::get('variable.admin_page_per_record'));
            $payments = Payment::with(['student', 'teacher'])->
                orderBy('created_at', 'desc')->get();
        }
        if ($id == 'today') {
            $paymentss = Payment::whereBetween('created_at', [strtotime('today'), time()])->with(['student', 'teacher'])->
                orderBy('created_at', 'desc')->paginate(\Config::get('variable.admin_page_per_record'));
            $payments = Payment::whereBetween('created_at', [strtotime('today'), time()])->with(['student', 'teacher'])->
                orderBy('created_at', 'desc')->get();
        }
        if ($id == 'weekly') {
            $paymentss = Payment::whereBetween('created_at', [strtotime('last sunday midnight'), time()])->with(['student', 'teacher'])->
                orderBy('created_at', 'desc')->paginate(\Config::get('variable.admin_page_per_record'));
            $payments = Payment::whereBetween('created_at', [strtotime('last sunday midnight'), time()])->with(['student', 'teacher'])->
                orderBy('created_at', 'desc')->get();

        }
        if ($id == 'monthly') {
            $this_month = strtotime(date('01-m-Y'));

            $paymentss = Payment::whereBetween('created_at', [$this_month, time()])->with(['student', 'teacher'])->
                orderBy('created_at', 'desc')->paginate(\Config::get('variable.admin_page_per_record'));
            $payments = Payment::whereBetween('created_at', [$this_month, time()])->with(['student', 'teacher'])->
                orderBy('created_at', 'desc')->get();
        }else{
            $this_month = strtotime(date('01-'.$id.'-Y'));

            if($id =='1' || $id =='3' || $id=='5'|| $id=='7' || $id =='8' ||$id=='10' || $id =='12'){
                $this_month_end = strtotime(date('31-'.$id.'-Y'));}
                if($id =='2'){
                    $this_month_end = strtotime(date('28-'.$id.'-Y'));}
   
                else{
                    $this_month_end = strtotime(date('30-'.$id.'-Y'));}

                    $payments = Payment::whereBetween('created_at', [$this_month, $this_month_end])->with(['student', 'teacher'])->
                orderBy('created_at', 'desc')->get();

        }

        $title = "Payment Management";

        $payment_array[] = array('Payment By', 'Payment To', 'Date', 'Amount', 'Status');
        foreach ($payments as $payment) {
            if ($payment->status == 0 || $payment->status == 1) {
                $status = "Processing";
            }if ($payment->status == 2) {
                $status = "Released";

            }if ($payment->status == 3) {
                $status = "Refunded";
            }
            $payment_array[] = array(
                'Payment By' => t($payment->student->name) ? $payment->student->nameisse : '',
                'Payment To' => isset($payment->teacher->name) ? $payment->teacher->name : '',
                'Date' => Date('y/m/d', $payment->created_at),
                'Amount' => $payment->amount_paid,
                'Status' => $status,

            );

        }

        ob_end_clean(); 
        ob_start();
        return Excel::download(new PaymentsExport($id), $id . 'revenue.xlsx');

        return view('admin.payments.payments', [
            'payments' => $paymentss->appends(request()->input('page')),
            'title' => $title,
        ]);}
    // Function for download coupons records excel file
    public function couponExcel($id)
    {
        ob_end_clean(); // this
        ob_start();
        return Excel::download(new CouponsExport($id), $id . 'coupon.xlsx');
    }

    //daily reports
     // Function for download coupons records excel file
     public function dailyReports()
     {
        $today_end              = strtotime('23:59:59');
        $yesterday_end          = strtotime('-1 day', $today_end); 
        $today_start              = strtotime('00:00:00');
        $yesterday_start          = strtotime('-1 day', $today_start);
        
        $date= date('d-m-Y', $yesterday_start);

// for($i=0;$i<= 10;$i++){


       
//         $date = "01"+$i."-09-2022";



//         $yesterday_start  = strtotime("01"+$i."-09-2022 00:00:00");
//         $yesterday_end  = strtotime("01"+$i."-09-2022 23:59:59");
 
        $check = DailyReport:: where('date',$date)->count();
        $host_signups = User::where('role_id',2)->whereBetween('created_at',[$yesterday_start,$yesterday_end])->count();
        $user_signups = User::where('role_id',3)->whereBetween('created_at',[$yesterday_start,$yesterday_end])->count();
        $logins =  User::whereBetween('updated_at',[$yesterday_start,$yesterday_end])->count();
        $class_hosted = BookedLesson::where('status', 3)->where('payment_flag', 1)->whereBetween('from_timing', [$yesterday_start,$yesterday_end])->groupBy('lesson_id')->get();
        $bookings = BookedLesson::whereIn('status',[1,3])->where('payment_flag', 1)->whereBetween('created_at', [$yesterday_start,$yesterday_end])->count();
        $revenue = BookedLesson::whereIn('status',[1,3])->where('payment_flag', 1)->whereBetween('created_at', [$yesterday_start,$yesterday_end])->sum('cost');
        $amount_paid = Payment::where('status','!=', 3)->whereBetween('created_at', [$yesterday_start,$yesterday_end])->get();
$total=0;
        if(count($amount_paid)==0){
            $total = 0;
        }else{
            foreach($amount_paid as $paid){
                $total+= ($paid->amount_paid-($paid->amount_paid * $paid->discount)/100)+0.99;
            }

        }
 $bookings = BookedLesson::whereIn('status',[1,3])->where('payment_flag', 1)->whereBetween('created_at', [$yesterday_start,$yesterday_end])->count();
if ($check==0){


  $create_daily_report = DailyReport:: create (['date'=>$date,'host_sign_ups'=>$host_signups,'user_sign_ups'=>$user_signups,'logins'=>$logins,'classes_hosted'=>count($class_hosted), 'revenue'=>$revenue,'amount_paid'=>$total,'number_of_bookings'=> $bookings,'created_at'=> time(),'updated_at'=> time()]);
}
//}
//}
         ob_end_clean(); // this
         ob_start();
         return Excel::download(new DailyreportExport(), 'dailyreport.xlsx');
     }
 

    /* get single payment detail */

    public function getPaymentDetail($id)
    {
        $payments = '';
        $title = "View Payment";
        $payment = Payment::where('id', $id)->with(['student', 'teacher', 'bookedLesson', 'cardDetail'])
            ->first();
        return view('admin.payments.payment_detail', compact('payment', 'title'));
    }
    // Function for download daily classes booked,cancel and hosted classes excel file

    public function dailyReport(Request $request, $id)
    {
       
       
        ob_end_clean(); // this
        ob_start();
        return Excel::download(new ReportsExport($id), $id . 'report.xlsx');

    }

    // Function for download daily visitors and tracked searched data
    public function dailyVisitors(Request $request, $id)
    {
        ob_end_clean();
        ob_start();
        if ($id == 'search_terms') {
            return Excel::download(new UsersExport($id), $id . 'users.xlsx');
        } else {
            return Excel::download(new UsersExport($id), $id . '.xlsx');

        }
    }

    // Function for download daily logins
    public function dailyLogins(Request $request, $id)
    {
        ob_end_clean();
        ob_start();
        return Excel::download(new LoginsExport($id), $id . 'logins.xlsx');
    }

    // Function for download daily classrequests to host
    public function dailyRequests(Request $request, $id)
    {
        ob_end_clean();
        ob_start();
        return Excel::download(new RequestsExport($id), $id . 'booking_requests.xlsx');
    }

    // Function for download deleted users data on the platform
    public function deletedUsers()
    {
        $deleted = DeletedUser::get();
        ob_end_clean(); // this
        ob_start();
        return Excel::download(new DeletedExport(), 'deleted_users.txt');
    }

    // Function for show daily,weekly and monthly booked, canceled and hosted classes
    public function reports(Request $request, $id)
    {

        $users = '';
        $title = "Daily Reports";
        $auth = Auth::user();
        #query use to get users in desc order

        $parameter = "";
        $now = strtotime('tomorrow');
        $ago_time = time();

        if ($id == 'today') {
            $reports = BookedLesson::where('status','!=',5)->whereBetween('from_timing', [strtotime('today'), time()])->with(['lessons', 'user', 'teacher'])->orderBy('created_at', 'desc')->paginate(\Config::get('variable.admin_page_per_record'));
            //dd($reports);
        }
        if ($id == 'weekly') {
            $reports = BookedLesson::where('status','!=',5)->with(['lessons', 'user', 'teacher'])->whereBetween('from_timing', [strtotime('last sunday midnight'), time()])->orderBy('created_at', 'desc')->paginate(\Config::get('variable.admin_page_per_record'));
        }
        if ($id == 'monthly') {
            $this_month = strtotime(date('01-m-Y'));
            $reports = BookedLesson::where('status','!=',5)->with(['lessons', 'user', 'teacher'])->where('payment_flag',1)->whereBetween('from_timing', [$this_month, time()])->orderBy('created_at', 'desc')->paginate(\Config::get('variable.admin_page_per_record'));
        }
        if ($id == 'booked_today') {
            $reports = BookedLesson::with(['lessons', 'user', 'teacher'])->where('payment_flag', 1)->whereBetween('from_timing', [strtotime('today'), time()])->where('status', 1)->orderBy('created_at', 'desc')->paginate(\Config::get('variable.admin_page_per_record'));
        }
        if ($id == 'booked_weekly') {
            $reports = BookedLesson::with(['lessons', 'user', 'teacher'])->where('payment_flag', 1)->where('status', 1)->whereBetween('from_timing', [strtotime('last sunday midnight'), time()])->orderBy('created_at', 'desc')->paginate(\Config::get('variable.admin_page_per_record'));
        }
        if ($id == 'booked_monthly') {
            $this_month = strtotime(date('01-m-Y'));
            $reports = BookedLesson::with(['lessons', 'user', 'teacher'])->where('payment_flag', 1)->where('status', 1)->whereBetween('from_timing', [$this_month, time()])->orderBy('created_at', 'desc')->paginate(\Config::get('variable.admin_page_per_record'));
        }
        if ($id == 'hosted_today') {
            $reports = BookedLesson::with(['lessons', 'user', 'teacher'])->where('payment_flag', 1)->whereBetween('from_timing', [strtotime('today'), time()])->where('status', 3)->orderBy('created_at', 'desc')->paginate(\Config::get('variable.admin_page_per_record'));
        }
        if ($id == 'hosted_weekly') {
            $reports = BookedLesson::with(['lessons', 'user', 'teacher'])->where('payment_flag', 1)->where('status', 3)->whereBetween('from_timing', [strtotime('last sunday midnight'), time()])->orderBy('created_at', 'desc')->paginate(\Config::get('variable.admin_page_per_record'));
        }
        if ($id == 'hosted_monthly') {
            $this_month = strtotime(date('01-m-Y'));
            $reports = BookedLesson::with(['lessons', 'user', 'teacher'])->where('payment_flag', 1)->where('status', 3)->whereBetween('from_timing', [$this_month, time()])->orderBy('created_at', 'desc')->paginate(\Config::get('variable.admin_page_per_record'));
        }

        if($id==1 || $id==2 || $id ==3 || $id ==4 || $id ==5 || $id ==6 || $id == 7 || $id ==8 || $id==9 || $id ==10 || $id == 11 || $id ==12){
           
                $this_month = strtotime(date('01-'.$id.'-Y'));
                if($id =='1' || $id =='3' || $id=='5'|| $id=='7' || $id =='8' ||$id=='10' || $id =='12'){
                $this_month_end = strtotime(date('31-'.$id.'-Y'));}
                if($id =='2'){
                    $this_month_end = strtotime(date('28-'.$id.'-Y'));}
    
                else{
                    $this_month_end = strtotime(date('30-0'.$id.'-Y 23:59:59'));}
    // dd($this_month_end);
                    $reports = BookedLesson::where('status','!=',5)->with(['lessons', 'user', 'teacher'])->where('payment_flag',1)->whereBetween('from_timing', [$this_month, $this_month_end])->orderBy('created_at', 'desc')->paginate(\Config::get('variable.admin_page_per_record'));
            
        }

        return view('admin.reports', [
            'reports' => $reports->appends(request()->input('page')),
            'title' => $title,
        ]);

    }

    // Function for show daily,weekly and monthly logins
    public function logins(Request $request, $id)
    {

        $users = '';
        $title = "Daily logins";
        $auth = Auth::user();
        #query use to get users in desc order

        $parameter = "";
        $now = strtotime('tomorrow');
        $ago_time = time();

        if ($id == 'today') {
            $logins = User::select('id', 'role_id', 'name', 'email', 'status', 'image', 'created_at', 'updated_at', 'average_time','current_login', 'last_login')->where('role_id', '!=', 1)->whereBetween('updated_at', [strtotime('today'), time()])->where('status',1)->orderBy('updated_at','desc')->paginate(\Config::get('variable.admin_page_per_record'));
        }
        if ($id == 'weekly') {

            $logins = User::select('id', 'name', 'role_id', 'email', 'status', 'image', 'created_at', 'updated_at', 'average_time', 'current_login','last_login')->where('status',1)->where('role_id', '!=', 1)->whereBetween('updated_at', [strtotime('last sunday midnight'), time()])->orderBy('updated_at','desc')->paginate(\Config::get('variable.admin_page_per_record'));
        }
        if ($id == 'monthly') {
            // dd('pk');
            $this_month = strtotime(date('01-m-Y'));
            $logins = User::select('id', 'name', 'role_id', 'email', 'status', 'image', 'created_at', 'updated_at', 'average_time', 'current_login','last_login')->whereBetween('updated_at', [$this_month, time()])->where('status',1)->where('role_id', '!=', 1)->orderBy('updated_at','desc')->paginate(\Config::get('variable.admin_page_per_record'));

        }
        if ($id == 'yearly') {
            $this_month = strtotime(date('y-1-1'));
            $logins = User::select('id', 'name', 'role_id', 'email', 'status', 'image', 'created_at', 'updated_at', 'average_time', 'current_login','last_login')->where('status',1)->where('role_id', '!=', 1)->whereBetween('updated_at', [$this_month, time()])->orderBy('updated_at','desc')->paginate(\Config::get('variable.admin_page_per_record'));
        }if($id==1 || $id==2 || $id ==3 || $id ==4 || $id ==5 || $id ==6 || $id == 7 || $id ==8 || $id==9 || $id ==10 || $id == 11 || $id ==12){
            $this_month = strtotime(date('01-'.$id.'-Y'));
            if($id =='1' || $id =='3' || $id=='5'|| $id=='7' || $id =='8' ||$id=='10' || $id =='12'){
            $this_month_end = strtotime(date('31-'.$id.'-Y'));}
            if($id =='2'){
                $this_month_end = strtotime(date('28-'.$id.'-Y'));}

            else{
                $this_month_end = strtotime(date('30-'.$id.'-Y'));}
                $logins = User::select('id', 'name', 'role_id', 'email', 'status', 'image', 'created_at', 'updated_at', 'average_time', 'current_login','last_login')->where('status',1)->where('role_id', '!=', 1)->whereBetween('updated_at', [$this_month,$this_month_end])->orderBy('updated_at','desc')->paginate(\Config::get('variable.admin_page_per_record'));

        }
        return view('admin.logins', [
            'logins' => $logins->appends(request()->input('page')),
            'title' => $title,
        ]);

    }

    // Function for show daily,weekly and monthly new classes requests 

    public function requests(Request $request, $id)
    {

        $users = '';
        $title = "Daily Requests";
        $auth = Auth::user();
        #query use to get users in desc order

        $parameter = "";
        $now = strtotime('tomorrow');
        $ago_time = time();

        if ($id == 'today') {
            // $requests = BookingRequest::with(['users', 'teacher'])->whereBetween('created_at', [strtotime('today'), time()])->orderBy('created_at', 'desc')->paginate(\Config::get('variable.admin_page_per_record'));

            $requests = BookingRequest::whereBetween('created_at', [strtotime('today'), time()])->with(['users', 'teacher'])
                ->selectRaw('max(id) as id, teacher_id,user_id, is_read,query,reply,status,created_at, updated_at')->groupBy('teacher_id')->orderBy('created_at', 'desc')->paginate(10);
              

$requestss=array();


                for ($i = 0; $i < count($requests) ; $i++) {
                  //  dd($requests[$i]);
                    array_push($requestss,$requests[$i]);
                   // dd($requests[$i]['teacher_id']);
                   $requestsss = BookingRequest::where('teacher_id',$requests[$i]['teacher_id'])->where('user_id', $requests[$i]['user_id'])->with(['users', 'teacher'])->orderBy('created_at', 'asc')->get();
                   
                             $requestss_detail[$i] = $requestsss;
                           
                           
                 }
//   $requestss = $requestss->paginate(\Config::get('variable.admin_page_per_record'));
                
// $requests = BookingRequest::with(['users', 'teacher'])->whereBetween('created_at', [strtotime('today'), time()])->orderBy('created_at', 'desc')->paginate(\Config::get('variable.admin_page_per_record'));
        }
        if ($id == 'weekly') {
            $requests = BookingRequest::with(['users', 'teacher'])->whereBetween('created_at', [strtotime('last sunday midnight'), time()])->groupBy('teacher_id')->orderBy('created_at', 'desc')->paginate(10);

            $requestss=array();


                for ($i = 0; $i < count($requests) ; $i++) {
                  //  dd($requests[$i]);
                    array_push($requestss,$requests[$i]);
                   // dd($requests[$i]['teacher_id']);
                   $requestsss = BookingRequest::where('teacher_id',$requests[$i]['teacher_id'])->where('user_id', $requests[$i]['user_id'])->with(['users', 'teacher'])->orderBy('created_at', 'asc')->get();
                   
                             $requestss_detail[$i] = $requestsss;
                           
                           
                 }
        }
        if ($id != 'weekly' && $id !='today') {

            if($id=='monthly'){
                $this_month = strtotime(date('01-m-Y'));
                $this_month_end =time();

            }else{
                $this_month = strtotime(date('01-'.$id.'-Y'));
                if($id =='1' || $id =='3' || $id=='5'|| $id=='7' || $id =='8' ||$id=='10' || $id =='12'){
                $this_month_end = strtotime(date('31-'.$id.'-Y'));}
                if($id =='2'){
                    $this_month_end = strtotime(date('28-'.$id.'-Y'));}
   
                else{
                    $this_month_end = strtotime(date('30-'.$id.'-Y'));}

                    // dd($this_month_end,$id);

                


            }
           
            $requests = BookingRequest::whereBetween('created_at', [$this_month, $this_month_end])->groupBy('teacher_id')->with(['users', 'teacher'])->paginate(10);
            $requests_count = BookingRequest::whereBetween('created_at', [$this_month, $this_month_end])->groupBy('teacher_id')->with(['users', 'teacher'])->get();
            // $requests_monthly = BookingRequest::whereBetween('created_at', [$this_month, time()])->groupBy('teacher_id')->groupBy('teacher_id')->paginate(10);
            // if(count($requests_count) !=0){
            $requestss=array();

if(count($requests)==0){
    $requestss_detail=[];
}
                for ($i = 0; $i < count($requests) ; $i++) {
                  //  dd($requests[$i]);
                    array_push($requestss,$requests[$i]);
                   // dd($requests[$i]['teacher_id']);
                   $requestsss = BookingRequest::where('teacher_id',$requests[$i]['teacher_id'])->where('user_id', $requests[$i]['user_id'])->with(['users', 'teacher'])->orderBy('created_at', 'asc')->get();
                   
                             $requestss_detail[$i] = $requestsss;
                           
                           
                 }

               
                // }else{

                //     return view('admin.requests', [
                //         'requests' => $requests->appends(request()->input('page')),
                //         'requestss'=>[],
                //         'title' => $title,
                //         'request_detail'=>[]
                //     ]);

                // }

        }   
        return view('admin.requests', [
            'requests' => $requests->appends(request()->input('page')),
            'requestss'=>$requestss ,
            'title' => $title,
            'request_detail'=> $requestss_detail
        ]);

    }
    // Function for show daily,weekly and monthly new users on the platform
    public function newUsers(Request $request, $id)
    {

        $users = '';
        $title = "New Users";
        $auth = Auth::user();
        #query use to get users in desc order

        $parameter = "";
        $now = strtotime('tomorrow');
        $ago_time = time();

        if ($id == 'today') {
            $users = User::select('id', 'role_id', 'name', 'email', 'status', 'image', 'created_at')->where('role_id', '!=', 1)->whereBetween('created_at', [strtotime('today'), time()])->paginate(\Config::get('variable.admin_page_per_record'));

        }
        if ($id == 'weekly') {

            $users = User::select('id', 'name', 'role_id', 'email', 'status', 'image', 'created_at')->where('role_id', '!=', 1)->whereBetween('created_at', [strtotime('last sunday midnight'), time()])->paginate(\Config::get('variable.admin_page_per_record'));
        }
        if ($id == 'monthly') {
            $this_month = strtotime(date('01-m-y'));
            $users = User::select('id', 'name', 'role_id', 'email', 'status', 'image', 'created_at')->where('role_id', '!=', 1)->whereBetween('created_at', [$this_month, time()])->paginate(\Config::get('variable.admin_page_per_record'));

        }
        if ($id == 'yearly') {
            $this_month = strtotime(date('y-1-1'));
            $users = User::select('id', 'name', 'role_id', 'email', 'status', 'image', 'created_at')->where('role_id', '!=', 1)->whereBetween('created_at', [$this_month, time()])->paginate(\Config::get('variable.admin_page_per_record'));
        }

        if ($id == 'logins_today') {
            $users = User::select('id', 'role_id', 'name', 'email', 'status', 'image', 'created_at')->where('role_id', '!=', 1)->whereBetween('updated_at', [strtotime('today'), time()])->paginate(\Config::get('variable.admin_page_per_record'));

        }
        if ($id == 'logins_weekly') {

            $users = User::select('id', 'name', 'role_id', 'email', 'status', 'image', 'created_at')->where('role_id', '!=', 1)->whereBetween('updated_at', [strtotime('last sunday midnight'), time()])->paginate(\Config::get('variable.admin_page_per_record'));
        }
        if ($id == 'logins_monthly') {
            $this_month = strtotime(date('y-m-1'));
            $users = User::select('id', 'name', 'role_id', 'email', 'status', 'image', 'created_at')->where('role_id', '!=', 1)->whereBetween('created_at', [$this_month, time()])->paginate(\Config::get('variable.admin_page_per_record'));

        }if($id==1 || $id==2 || $id ==3 || $id ==4 || $id ==5 || $id ==6 || $id == 7 || $id ==8 || $id==9 || $id ==10 || $id == 11 || $id ==12){            $this_month = strtotime(date('01-'.$id.'-Y'));
            if($id =='1' || $id =='3' || $id=='5'|| $id=='7' || $id =='8' ||$id=='10' || $id =='12'){
            $this_month_end = strtotime(date('31-'.$id.'-Y'));}
            if($id =='2'){
                $this_month_end = strtotime(date('28-'.$id.'-Y'));}

            else{
                $this_month_end = strtotime(date('30-'.$id.'-Y'));}
                $users = User::select('id', 'name', 'role_id', 'email', 'status', 'image', 'created_at')->where('role_id', '!=', 1)->whereBetween('created_at', [$this_month, $this_month_end])->paginate(\Config::get('variable.admin_page_per_record'));
        }
        return view('admin.new_users', [
            'users' => $users->appends(request()->input('page')),
            'title' => $title,
        ]);

    }


    // Function for list of deleted users

    public function deletedUsersList(Request $request)
    {

        $users = '';
        $title = "Deleted Users";
        $auth = Auth::user();
        #query use to get users in desc order


        $deleted_users = DeletedUser::orderBy('created_at', 'desc')->paginate(\Config::get('variable.admin_page_per_record'));
    

        return view('admin.deleted_users', [
            'deleted_users' => $deleted_users->appends(request()->input('page')),
            'title' => $title,
        ]);

    }
}
