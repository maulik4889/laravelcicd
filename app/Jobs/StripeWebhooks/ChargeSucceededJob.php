<?php

namespace App\Jobs\StripeWebhooks;

use App\Models\BookedLesson;
use App\Models\Lesson;
use App\Models\Payment;
use App\Models\Notification;
use App\Models\UserSubscription;
use Datetime;
use DateTimeZone;
use App\User;
use Mail;
use Config;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\WebhookClient\Models\WebhookCall;
use App\Http\Traits\CommonTrait;
use App\Http\Traits\UserTrait;
class ChargeSucceededJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, CommonTrait, UserTrait;
        /**@var \Spatie\WebhookClient\Models\WebhookCall */
public $webhookCall;

public function __construct(WebhookCall $webhookCall)
{
    $this->webhookCall = $webhookCall;
}

public function handle()
{
    $charge = $this->webhookCall->payload;
    $transfer = $this->webhookCall->payload['data']['object'];

    if($charge['type'] =='payment_intent.succeeded'){
        
        // $payment = Payment::where('card_id',$transfer['id'])->first();
        // $lesson = BookedLesson::where('id',$payment->lesson_id)->with('lessons')->first();
        // $destination_id = $lesson->teacher_id;
        // $amount = $transfer['amount']/100;
        // $admin_charges = number_format(($amount) * 15 / 100, 2);
        // $amount_to_pay = ($amount -$admin_charges) *100; 
        // $requested_data['user_id'] = $lesson->student_id;
        // $requested_data['receiver_id'] = $lesson->teacher_id;
        // $requested_data['lesson_id'] = $lesson->id;
        // $requested_data['type'] = 4; //accept request .
        // $notifiicaton= Notification::create(['sender_id'=>$lesson->student_id,'receiver_id'=>
        // $lesson->teacher_id,'status'=>1,'lesson_id'=>$lesson->id,'type'=>4,'created_at'=>time(),'updated_at'=>time()]);
        // $repeat_notification =  Notification::create(['sender_id'=>$lesson->student_id,'receiver_id'=>
        // $lesson->student_id,'status'=>1,'lesson_id'=>$lesson->id,'type'=>4,'created_at'=>time(),'updated_at'=>time()]);
    
        // $student_email = User::where('id',$lesson->student_id)->first()->email;
        // $teacher_email = User::where('id',$lesson->teacher_id)->first()->email;
    //    $subs = UserSubscription::where('user_id',$lesson->teacher_id)->count();
    //     if($subs==0){
    //         $subs_id = 0;
    //     }else{
    //         $subs_id = UserSubscription::where('user_id',$lesson->teacher_id)->first()->subscription_id;

    //     } 

        // $class_name = $lesson->class_name;
        // $name = User::where('id',$lesson->student_id)->first()->full_name;
        // $teacher_name = User::where('id',$lesson->teacher_id)->first()->full_name;
        // $currency= $lesson->currency;
        // $cost = $lesson->cost;
        // $start_url = $lesson->start_url;
        // $join_url = $lesson->join_url;
        // if($subs==0){
        //     $cost1 =   number_format($cost*0.85, 2, '.', ',');
        // }else{
        //     $cost1 =   number_format($cost, 2, '.', ',');
        // }
      
    //     date_default_timezone_set('Europe/London');
    
    //     $gmtTimezone = date_default_timezone_get();
    //     $gmtTimezone = new DateTimeZone($gmtTimezone);
    
    //     $myDateTime =date("d-m-y h:i:s A", $lesson->from_timing);
    //     $date = new DateTime($myDateTime, $gmtTimezone);
    //     $date1 = $date->format('d-m-y');
    //     $time = $date->format('h:i A');
    
    //     // $message = $request->question;
    //     $admin_email = Config::get('variable.ADMIN_EMAIL');
    //     $frontend_url = Config::get('variable.FRONTEND_URL');
    //     Mail::send('emails.users.booking_request', [
    //             "data" => array(
    //                 "name"=> $name,
    //                 "class_name"=> $class_name,
    //                 "currency"=> $currency,
    //                 "email" => $student_email,
    //                 "cost" =>  number_format($cost, 2, '.', ',') ,
    //                 "teacher_name" => $teacher_name ,
    //                 "date" => $date1 ,
    //                 "time" => $time ,
    //                 "subs"=>$subs,
    //                 "join_url" => $join_url,
    //                 "start_url" => $start_url,
    
    //             )],function($message) use ($student_email, $admin_email)
    // {
    //         $message->from($admin_email, config('variable.SITE_NAME'));
    //         $message->to($student_email, config('variable.SITE_NAME'))->subject('Class Booking Confirmation on Matutto.com');
    //     });
    //     Mail::send('emails.users.booking_teacher', [
    //         "data" => array(
    //             "name"=> $name,
    //             "class_name"=> $class_name,
    //             "currency"=> $currency,
    //             "email" => $student_email,
    //             "cost" =>$cost1,
    //             "teacher_name" => $teacher_name,
    //             "date" => $date1,
    //             "time" => $time,
    //             "subs"=>$subs,
    //             "join_url" => $join_url,
    //             "start_url" => $start_url,


    //         )],function($message) use ($teacher_email, $admin_email)
    // {
    //     $message->from($admin_email, config('variable.SITE_NAME'));
    //     $message->to($teacher_email, config('variable.SITE_NAME'))->subject('You Have A New Class Booking on Matutto.com');
    // });
    
    // $update_slots = BookedLesson::where('id',$lesson->id)->decrement('no_of_slots', 1);
    // $lesson_id = BookedLesson::where('id',$lesson->id)->first()->lesson_id;
    // $update_create_slots = Lesson::where('id',$lesson_id)->decrement('no_of_slots', 1);
    //     $update_status = BookedLesson::where('id', $lesson->id)->update(['payment_flag'=>1,'status'=>1]);
    //     $payment_intent = Payment::where('lesson_id',$lesson->id)->where('student_id',$lesson->student_id)->first()->card_id;
    //     $update_payment_intent = Payment::where('lesson_id',$lesson->id)->where('student_id',$lesson->student_id)->update(['charge_id'=> $transfer['charges']['data'][0]['id'],'subscription_id'=>$subs_id]);
      
    }
    if($charge['type']=='payout.paid' || $charge['type']=='transfer.paid'){
        $payment = Payment::where('charge_id',$transfer['source_transaction'])->first();
        $paymentss = Payment::where('charge_id',$transfer['source_transaction'])->update(['status'=>2]);

        $lessondetail = BookedLesson::where('id',$payment->lesson_id)->with(['user','teacher'])->first();
        $name = User::where('id',$lessondetail->teacher_id)->first()->full_name;
        $currency= $lessondetail->currency;
        $cost = $lessondetail->cost;
        $teacher_email=User::where('id',$lessondetail->teacher_id)->first()->email;
    
        // $message = $request->question;
        $admin_email = Config::get('variable.ADMIN_EMAIL');
        $frontend_url = Config::get('variable.FRONTEND_URL');
        Mail::send('emails.users.transfer_paid', [
            "data" => array(
                "name"=> $name,
                "currency"=> $currency,
                "amount" => number_format($cost*0.8, 2, '.', ',') ,
         
            )],function($message) use ($teacher_email, $admin_email)
    {
        $message->from($admin_email, config('variable.SITE_NAME'));
        $message->to($teacher_email, config('variable.SITE_NAME'))->subject('Your earnings are on your way');
    });
    }

    if($charge['type']=='account.updated'){
        if(isset($transfer['individual']) ){
            if(count($transfer['requirements']['errors'])  >=1){
               $err = $transfer['requirements']['errors'][0]['reason']; 
            // }else{

            //     $err = $transfer['individual']['verification']['details']; 
            // }
            $sender_id = User::where('customer_id',$transfer['id'])->first()->id;

            $count=Notification ::where(['sender_id'=>$sender_id,'receiver_id'=>$sender_id,'type'=>'14','message'=> $err])->count();
            if($count==0){
            $notification=Notification ::create(['sender_id'=>$sender_id,'receiver_id'=>$sender_id,'status'=>0,'type'=>'14','message'=> $err,'created_at'=>time(),'updated_at'=>time()]);
            $name =User::where('customer_id',$transfer['id'])->first()->full_name;
            $email= User::where('customer_id',$transfer['id'])->first()->email;;
            $message=  $err;
            $subject= 'Identity Verification Failed';
    
            $admin_email = Config::get('variable.ADMIN_EMAIL');
            $frontend_url = Config::get('variable.FRONTEND_URL');
            Mail::send('emails.users.manual_mail', [
                    "data" => array(
                        "name"=> $name,
                        "email"=> $email,

                        "message"=> $message,
  
                    )],function($message) use ($email, $admin_email,$subject)
        {
                $message->from($admin_email, config('variable.SITE_NAME'));
                $message->to($email, config('variable.SITE_NAME'))->subject($subject);
            });
            }
        }
        }
    }
    
}
}
