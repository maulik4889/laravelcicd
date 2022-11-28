<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Traits\CommonTrait;
use App\Http\Traits\UserTrait;
use App\Interfaces\HomeInterface;
use App\Models\Neighbourhood;
use App\Models\ChecklistCategory;
use App\Models\UserChecklistTask;

use App\Models\ChecklistTask;

use DB;
use App\Models\Role;
use App\Models\Blog;
use App\User;
use Auth;
use Config;
use Illuminate\Http\Request;
use Mail;
use Response;
use Stripe\Stripe;

class HomeController extends Controller implements HomeInterface
{
    use CommonTrait, UserTrait;


    // code for get neibours api in london-guide page
    public function getNeighnourhoods(Request $request){
        $neibours = Neighbourhood::get();
        $data = \Config::get('success.contact_us');
            $data['data'] = $neibours;
            return Response::json($data);
    }

    // post data for best neibour vote
    public function bestNeighbours(Request $request)
    {
    
        $name = 'Admin';
        $email =$request->email;
        $type= $request->type;
        $place= isset($request->place) ? $request->place : '';

        if($request->type =='2'){
            $message ='You received a new  message about london expat '.$request->page;
            $subject = 'New message about london expat';

        }else{
            $message ='You received a new vote for best neighbourhood in london from page '.$request->page;
            $subject = 'New best neighbourhood vote';

        }

        $admin_email = Config::get('variable.ADMIN_EMAIL');
        $frontend_url = Config::get('variable.FRONTEND_URL');
        Mail::send('emails.users.london_guide', [
            "data" => array(
                "name" => $name,
                "email" => $email,
                "message" => $message,
                "place" => $place,
                "type" => $type,

            )], function ($message) use ($email, $admin_email, $subject) {
            $message->from($admin_email, config('variable.SITE_NAME'));
            $message->to($admin_email, config('variable.SITE_NAME'))->subject($subject);
        });

        if (count(Mail::failures()) > 0) {
            $data = \Config::get('error.error_sending_email');
            $data['data'] = (object) [];
            return Response::json($data);
        } else {
            $data = \Config::get('success.contact_us');
            $data['data'] = (object) [];
            return Response::json($data);
        }
    }

    // Create email checklist in london-guide page
    public function checklist(Request $request)
    {
      
        $name = 'Admin';
        $email =$request->email;



        $message ='You received a new checklist request from page '.$request->page;
        $subject = 'New checklist subsribe email';

        $admin_email = Config::get('variable.ADMIN_EMAIL');
        $frontend_url = Config::get('variable.FRONTEND_URL');
        Mail::send('emails.users.help_support', [
            "data" => array(
                "name" => $name,
                "email" => $email,
                "message" => $message,


            )], function ($message) use ($email, $admin_email, $subject) {
            $message->from($admin_email, config('variable.SITE_NAME'));
            $message->to($admin_email, config('variable.SITE_NAME'))->subject($subject);
        });

        if (count(Mail::failures()) > 0) {
            $data = \Config::get('error.error_sending_email');
            $data['data'] = (object) [];
            return Response::json($data);
        } else {
            $data = \Config::get('success.contact_us');
            $data['data'] = (object) [];
            return Response::json($data);
        }
    }

    public function bookingEnquiry(Request $request)
    {
        $name = 'Admin';
        $email =$request->email;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.mailerlite.com/api/v2/groups/111206524/subscribers",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\"email\":\"$email\", \"name\": \"''\", \"fields\": {\"company\": \"MailerLite\"}}",
            CURLOPT_HTTPHEADER => array(
            "content-type: application/json",
            "x-mailerlite-apikey: bd9b896677d244ba5745e77b059cc84f"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        $message ='You received a new booking request from page'.$request->page;
        $subject = 'Free Booking Spot';

        $admin_email = Config::get('variable.ADMIN_EMAIL');
        $frontend_url = Config::get('variable.FRONTEND_URL');
        Mail::send('emails.users.help_support', [
            "data" => array(
                "name" => $name,
                "email" => $email,
                "message" => $message,


            )], function ($message) use ($email, $admin_email, $subject) {
            $message->from($admin_email, config('variable.SITE_NAME'));
            $message->to($admin_email, config('variable.SITE_NAME'))->subject($subject);
        });

        if (count(Mail::failures()) > 0) {
            $data = \Config::get('error.error_sending_email');
            $data['data'] = (object) [];
            return Response::json($data);
        } else {
            $data = \Config::get('success.contact_us');
            $data['data'] = (object) [];
            return Response::json($data);
        }
    }

    //fetch checklist tasks
    public function getChecklistTasks(){
        $tasks = ChecklistCategory::where('status',1)->with('tasks','tasks.userTask')->get();
        $data = \Config::get('success.contact_us');
        $data['data'] = $tasks;
        return Response::json($data);
    }

   public function addTaskToUserChecklist(Request $request){

$check_already_added = UserChecklistTask::where('user_id',Auth::user()->id)->where('task_id',$request->task_id)->count();
if($check_already_added==0){
    $add_task = UserChecklistTask::create(['user_id'=>Auth::user()->id,'task_id'=> $request->task_id,'status'=>1,'created_at'=>time(),'updated_at'=>time()]);

}else{
    $delete_checklist_task = UserChecklistTask::where('user_id',Auth::user()->id)->where('task_id',$request->task_id)->delete();

    
}

$data = \Config::get('success.contact_us');
        $data['data'] = (object) [];
        return Response::json($data);
   }

   public function getTaskPercentage(){

    $all_tasks= ChecklistTask::where('status',1)->count();
    $user_selected_tasks = UserChecklistTask::where('user_id',Auth::user()->id)->count();
    $percentage = number_format(($user_selected_tasks/$all_tasks)*100);

    $data = \Config::get('success.contact_us');
        $data['data'] = $percentage;
        return Response::json($data);

   }

   public function getUserNonSelectedCheckList(){

    $user_selected_tasks= UserChecklistTask::where('user_id',Auth::user()->id)->pluck('task_id');
    $user_non_selected_tasks= ChecklistTask::whereNotIn('id',$user_selected_tasks)->take(3)->get();

    $data = \Config::get('success.contact_us');
        $data['data'] = $user_non_selected_tasks;
        return Response::json($data);

   }
   
}