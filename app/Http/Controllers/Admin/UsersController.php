<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\DeletedUser;
use App\Models\Role;
use App\Models\UserReport;

use App\User;
use Auth;
use DateTime;
use DB;
use Excel;use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Mail;
use Redirect;

class UsersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

    }

    /* change password */

    public function getChangePassword()
    {
        $users = '';
        $title = "Change Password";

        return view('admin.users.change_password', compact('title'));
    }

    /*
     * Main Function to change password user
     * @param Request $request (current_password, new_password,confirm_new_password mandtary fields)
     * @return (status, success/error)
     */

    public function PostChangePassword(Request $request)
    {
        $rules = $this->validate($request, [
            'current-password' => 'required',
            'password' => 'required|same:password|min:6',
            'password_confirmation' => 'required|same:password',
        ]);

        $current_password = Auth::User()->password;
        if (Hash::check($request['current-password'], $current_password)) {
            $user_id = Auth::User()->id;
            $obj_user = User::find($user_id);
            $obj_user->password = Hash::make($request['password']);
            $obj_user->save();
            return redirect()->route('admin.getchange.password')->with([
                'flash_level' => 'success',
                'flash_message' => 'Your password has been changed successfully.',
            ]);
        } else {
            return Redirect::back()->with([
                'flash_level' => 'danger',
                'flash_message' => 'Please enter correct current password.',
            ]);

        }

    }

/* get dashboard page on admin panel */

    public function dashboard()
    {
        $this_month = strtotime(date('y-m-1'));
        $this_year = strtotime(date('1-1-y'));

        $users = '';
        $title = "Dashboard";
        $deleted_users = DeletedUser::count();
        $total_visitors = User::where('status', '!=', 4)->count();
        $today_visitors = User::whereBetween('created_at', [strtotime('today'), time()])->count();
        $weekly_visitors = User::where('role_id', '!=', 1)->whereBetween('created_at', [strtotime('last sunday midnight'), time()])->count();
        $monthly_visitors = User::where('role_id', '!=', 1)->whereBetween('created_at', [$this_month, time()])->count();
        $yearly_visitors = User::where('role_id', '!=', 1)->whereBetween('created_at', [$this_year, time()])->count();



        $today_logins = User::whereBetween('updated_at', [strtotime('today'), time()])->where('status',1)->count();
        $monthly_logins = User::whereBetween('updated_at', [$this_month, time()])->where('status',1)->count();

        $weekly_logins = User::whereBetween('updated_at', [strtotime('last sunday midnight'), time()])->where('status',1)->count();
        $life_route = 0;
        $this_year = new DateTime('first day of this year');

        return view('admin.dashboard', compact('total_visitors', 'today_visitors', 'yearly_visitors', 'weekly_visitors', 'monthly_visitors', 'today_logins','weekly_logins', 'monthly_logins','deleted_users'));
    }

    /* get hosts list */
    public function getList(Request $request,$id)
    {
        $users = '';
        $title = "User Management";
        $auth = Auth::user();
        #query use to get users in desc order
        $users = User::where('role_id', 2)
            ->where('status', '!=', 4)
            ->orderBy('created_at', 'desc');

        $parameter = "";

        if (isset($request->sort_by)) {
            if ($request->sort_by == 1) {
                $users = $users->orderBy('created_at', 'desc');
            } elseif ($request->sort_by == 2) {
                $users = $users->orderBy('created_at', 'ASC');
            } elseif ($request->sort_by == 3) {
                $users = $users->orderBy('updated_at', 'desc');
            } elseif ($request->sort_by == 4) {
                $users = $users->orderBy('updated_at', 'ASC');
            } else {
                $users = $users->orderBy('created_at', 'desc');
            }

        } else {
            $users = $users->orderBy('created_at', 'desc');
        }

        if (isset($request->name)) {

            $parameter = $request->name;
            $users = $users->where(function ($query) use ($parameter) {
                $query->where('email', 'like', '' . $parameter . '%')->orWhere('name', 'like', '' . $parameter . '%');
            });
        }

        $users = $users->paginate(\Config::get('variable.admin_page_per_record'));

        return view('admin.users.users', [
            'users' => $users->appends(request()->input('page')),
            'title' => $title,
        ]);
        

    }

    public function signupFilter($id)
    {
        $title = "User Management";
        if($id=='all'){
            $users = User::where('role_id', 2)
            ->where('status', '!=', 4)
            ->orderBy('created_at', 'desc');
            $users = $users->paginate(\Config::get('variable.admin_page_per_record'));
        }else{

        
        $users = User::where('role_id', 2)
        ->where('status', '!=', 4)->where('signup_type',$id)
        ->orderBy('created_at', 'desc');
        $users = $users->paginate(\Config::get('variable.admin_page_per_record'));
        }
        return view('admin.users.users', [
            'users' => $users->appends(request()->input('page')),
            'title' => $title,
        ]);
    }
    public function signupFilterUser($id)
    {
        $title = "User Management";

        $users = User::where('role_id', 2)
        ->where('status', '!=', 4)->where('signup_type',$id)
        ->orderBy('created_at', 'desc');
        $users = $users->paginate(\Config::get('variable.admin_page_per_record'));

        return view('admin.users.users', [
            'users' => $users->appends(request()->input('page')),
            'title' => $title,
        ]);
    }

    /* get single user profile detail */
    public function getUserDetail($id)
    {
        $users = '';
        $title = "View User";
        $user = User::where('id', $id)->select('id', 'role_id','name', 'dob', 'nationality', 'status', 'image','profile_steps','moving_reason','created_at')
            ->first();
          //  dd($user->image);
            $image = str_replace('thumb','medium',$user->image);

        // dd($user);
        return view('admin.users.user_detail', compact('user', 'title','image'));
    }

    
    /* get single user profile detail */
    public function hideUnhideProfile($id)
    {

        
        $users = '';
        $title = "Hide Profile";
        $hide_profile = User::where('id', $id)
            ->first()->hide_profile;
if($hide_profile==1){
    $status=0;
}else{
    $status=1;

}
            $update_profile = User::where('id', $id)
            ->update(['hide_profile'=>$status]);
        

            return Redirect::back()->with([
                'flash_level' => 'success',
                'flash_message' => 'Success',
            ]);
        //return view('admin.users.user_detail', compact('user', 'title','image'));
    }

    /* delete user into Database */

    public function delete(Request $request)
    {
        $user = User::where('id', $request->id)->first();

        $user_data = User::where('id', $request->id)->delete();

        $data1 = array();
        if ($user_data) {
            $data1["status"] = 200;
            $data1["response"] = 'User deleted successfully.';
        } else {
            $data1["status"] = 400;
            $data1["response"] = 'There was an error while deleting user.';
        }
        echo json_encode($data1);
    }

    /* chnage status user  */

    public function status(Request $request)
    {

        $project_name = \Config::get('app.name');
        $data = [];
        $users = User::find($request->id);
        //  $us = User::where('id',$request->id)->select('id','user_email')->first();

        // if($us->user_email == 1)
        // {
        $admin_email = \Config::get('variable.ADMIN_EMAIL');
        #  send mail to admin

        //  $message = $requested_data['message'];
        if ($request->status == '1') {
            $subject = 'Account Activated';
        } else {
            $subject = 'Account De-activated';
        }
        $name = $users->name;
        $email = $users->email;
        $admin_email = \Config::get('variable.ADMIN_EMAIL');

      
        # update data
        $users = $users->update(['status' => $request->status]);

        if ($users) {

            if ($request->status == '1') {
                $data["status"] = 200;
                $data["response"] = 'User account has been activated successfully.';
            } else {
                $data["status"] = 200;
                $data["response"] = 'User account has been de-activated successfully.';
            }

        } else {
            $data["status"] = 400;
            $data["response"] = 'There was an error while stuats change user.';
        }
        echo json_encode($data);
    }

    /* chnage  email status user  */

    public function emailStatus(Request $request)
    {

        $data = [];

        $user = DB::table('users')
            ->where('id', $request->id)
            ->update(['user_email' => $request->status]);

        if ($user) {

            if ($request->status == '1') {
                $data["status"] = 200;
                $data["response"] = 'User email status has been activated successfully.';
            } else {
                $data["status"] = 200;
                $data["response"] = 'User email status has been de-activated successfully.';
            }

        } else {
            $data["status"] = 400;
            $data["response"] = 'There was an error while stuats change user.';
        }
        echo json_encode($data);
    }




    /* get users list */
    public function getStudentList(Request $request)
    {
        $users = '';
        $title = "User Management";
        $auth = Auth::user();
        #query use to get users in desc order
        $users = User::where('role_id', 2)
            ->where('status', '!=', 4)
            ->orderBy('created_at', 'desc');

        $parameter = "";

        if (isset($request->sort_by)) {
            if ($request->sort_by == 1) {
                $users = $users->orderBy('created_at', 'desc');
            } elseif ($request->sort_by == 2) {
                $users = $users->orderBy('created_at', 'ASC');
            } elseif ($request->sort_by == 3) {
                $users = $users->orderBy('updated_at', 'desc');
            } elseif ($request->sort_by == 4) {
                $users = $users->orderBy('updated_at', 'ASC');
            } else {
                $users = $users->orderBy('created_at', 'desc');
            }

        } else {
            $users = $users->orderBy('created_at', 'desc');
        }

        if (isset($request->name)) {

            $parameter = $request->name;
            $users = $users->where(function ($query) use ($parameter) {
                $query->where('email', 'like', '' . $parameter . '%')->orWhere('name', 'like', '' . $parameter . '%');
            });
        }

        $users = $users->paginate(\Config::get('variable.admin_page_per_record'));

        return view('admin.users.students', [
            'users' => $users->appends(request()->input('page')),
            'title' => $title,
        ]);

    }

    public function confirmPassword(Request $request)
    {
        // $rules = $this->validate($request, [
        //     'current-password' => 'required',
        //     'password' => 'required|same:password|min:6',
        //     'password_confirmation' => 'required|same:password',
        // ]);

        $current_password = Auth::User()->password;
        if (Hash::check($request['password'], $current_password)) {

            return Redirect::route('admin.user.detail', $request->id);
        } else {
            return Redirect::back()->with([
                'flash_level' => 'danger',
                'flash_message' => 'Please enter correct password.',
            ]);

        }

    }


    public function confirmPasswordForDelete(Request $request)
    {
        // $rules = $this->validate($request, [
        //     'current-password' => 'required',
        //     'password' => 'required|same:password|min:6',
        //     'password_confirmation' => 'required|same:password',
        // ]);

        $current_password = Auth::User()->password;
        if (Hash::check($request['password'], $current_password)) {
$delete= User::where('id',$request->id)->delete();

return Redirect::back()->with([
    'flash_level' => 'Sucess',
    'flash_message' => 'Deleted Successfully',
]);
        } else {
            return Redirect::back()->with([
                'flash_level' => 'danger',
                'flash_message' => 'Please enter correct password.',
            ]);

        }

    }

    /* show a form to send manual emails to users */
    public function getEmailForm()
    {
        $title = "Send Emails";
        return view('admin.emails.send_email', compact('title'));

    }

    /* send manual  emails to users */

    public function postEmails(Request $request)
    {
        # validation 

        $rules = $this->validate($request, [
            //  'name'      => 'required|regex:/^[a-zA-Z]+$/u|max:255|unique:skill,meta_key',
            'subject' => 'required|max:255|',
            'message' => 'required|max:1000',
            'email' => 'required|email',
            'name' => 'required',

        ]);
        $name = $request->name;
        $email = $request->email;
        $message = $request->message;
        $subject = $request->subject;

        $admin_email = Config::get('variable.ADMIN_EMAIL');
        $frontend_url = Config::get('variable.FRONTEND_URL');
        Mail::send('emails.users.manual_mail', [
            "data" => array(
                "name" => $name,
                "message" => $message,

            )], function ($message) use ($email, $admin_email, $subject) {
            $message->from($admin_email, config('variable.SITE_NAME'));
            $message->to($email, config('variable.SITE_NAME'))->subject(config('variable.SITE_NAME') . ' :' . $subject);
        });

      
        return Redirect::back()->with(['flash_level' => 'success',
            'flash_message' => 'Email sent',
        ]);

    }

  


}
