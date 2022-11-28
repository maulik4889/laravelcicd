<?php

namespace App\Models;

use App\User;
use App\Models\BookedLesson;
use Auth;
use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon;

class Notification extends Model {

    public $timestamps = false;
    protected $fillable = [
        'lesson_id', 'sender_id', 'message','receiver_id', 'type', 'is_read', 'status', 'created_at','updated_at'
    ];

    # function for relation with post model
    public function booklessons()
   {
       return $this->belongsTo(BookedLesson::class,'lesson_id','id');
   }


     # function for get date time
  //  public function getCreatedAtAttribute($value) {
  // $value = date("y-m-d h:i:s", $value);
  // $value = $value->diffForHumans();
  //   dd($value);      return $value;
  //  }


   # function for relation with user model for receiver id
    public function receiver() {
        return $this->belongsTo(User::class,'receiver_id','id');
    }
    # function for relation with user model for sender  id
    public function sender() {
        return $this->belongsTo(User::class,'sender_id','id')->select('id','full_name','image','role_id');
    }
    public static function getTypeAttribute($value) {
        if($value == 1)  
        {
          $value = 'sent you a class request';
          return $value;
        }
        if($value == 2)  
        {
          $value = 'just accepted your booking request. You can now pay and book the class.';
          return $value;
        }
        if($value == 3)  
        {
          $value ='has pay the cost.';
          return $value;
        }
        if($value == 4){
          $value=4;
          return $value;
        }
        if($value == 5){
          $value=5;
          return $value;
        }
        if($value == 6)  
        {
          $value ='liked your post.';
          return $value;
        }
        if($value == 7){
          $value=7;
          return $value;
        }
        if($value == 8){
          $value=8;
          return $value;
        }  
        if($value == 9)  
        {
          $value ='comment on your post.';
          return $value;
        }   
        if($value == 10){
          $value=10;
          return $value;
        }   
        if($value == 11){
          $value=11;
          return $value;
        }  if($value == 12){
          $value=12;
          return $value;
        }    if($value == 13){
          $value=13;
          return $value;
        } 
        if($value == 14){
          $value=14;
          return $value;
        } 
        if($value == 15){
          $value=15;
          return $value;
        } 
}
}
