<?php

namespace App;

use Config;
use App\Models\BlockedUser;
use App\Models\Role;
use App\Models\Post;
use App\Models\UserCategory;
use App\Models\UserQualification;
use App\Models\UserSubject;
use App\Models\FeaturedHost;

use App\Models\Lesson;
use App\Models\BookedLesson;
use App\Models\UserInterest;
use App\Models\Notification;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Passport\HasApiTokens;
use Auth;

class User extends Authenticatable
{
    public $timestamps = false;
    use Notifiable, HasApiTokens;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = ['role_id', 'name', 'slug','dob','nationality','moving_reason','currency',
         'email','secondary_email','password', 'image', 'verify_token',
        'forgot_password_token','about', 'authentication_token', 'status', 'remember_token',
        'deleted_at', 
    'subscription_id','created_at','updated_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function AauthAcessToken()
    {
        return $this->hasMany('\App\OauthAccessToken');
    }

    public function role()
    {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }
    

    // path of documet
    public function getImageAttribute($value)
    {   
       $result = substr($value, 0, 4);
      
       if($result == 'http')  # if image from facebook
       {
         return $value;
       }

        $server_url = Config::get('variable.SERVER_URL');
        if (!empty($value) && file_exists(storage_path() . '/app/public/user/' . $value)) {
            return $server_url . '/storage/user/' . $value;
        } else {
            return $server_url . '/images/user-default.png';
        }
    }

    
     # function for relation with notification model
    public function un_read_noti() {
        return $this->hasMany(Notification::class,'receiver_id','id')->where('is_read',0)->where('status',1);
    }

    # my blocks
    public function blockMyusers()
    {
        return $this->hasMany(BlockedUser::class, 'blocked_to', 'id')->where('blocked_by',Auth::user()->id);
    }

    # blocks tp me 
    public function blockMeusers()
    {
        return $this->hasMany(BlockedUser::class, 'blocked_by', 'id')->where('blocked_to',Auth::user()->id);
    }

    #user interests
    public function userInterests()
    {
        return $this->hasMany(UserInterest::class, 'user_id', 'id');
    }

    #user subjects
    public function userSubjects()
    {
        return $this->hasMany(UserSubject::class, 'user_id', 'id');
    }
    #user skillls
    public function userCategories()
    {
        return $this->hasMany(UserCategory::class, 'user_id', 'id');
    }
    #user qualifications
    public function userQualifications()
    {
        return $this->hasMany(UserQualification::class, 'user_id', 'id');
    }
    #user lesson created
    public function createLessons()
    {
        return $this->hasMany(Lesson::class, 'user_id', 'id')->where('from_timing','>',time())->orWhere('always_on_class',1)->orderBy('from_timing','asc')->take(4);
    }
        #user lesson created
        public function createLessonsAll()
        {
            return $this->hasMany(Lesson::class, 'user_id', 'id')->where('from_timing','>',time())->orderBy('from_timing','asc');
        }

    //always on classes
    public function alwaysOnLessons()
    {
        return $this->hasMany(Lesson::class, 'user_id', 'id')->where('always_on_class',1);
    }
    public function completedLessons()
    {
        return $this->hasMany(BookedLesson::class, 'teacher_id', 'id')->where('status',3);
    }
    public function attendedLessons()
    {
        return $this->hasMany(BookedLesson::class, 'student_id', 'id')->where('status',3);
    }
    #feeds
    public function feeds()
    {
        return $this->hasMany(Post::class, 'user_id', 'id');
    }
    public function follow()
    {
        return $this->hasOne('App\Models\Follower', 'follower_to', 'id');
    }
    public function myFollower()
    {
        return $this->hasMany('App\Models\Follower', 'follower_to', 'id');
    }
public function availability()
{
    return $this->hasMany('App\Models\Availability', 'user_id', 'id')->where('status',1);
}
public function availabilityTimings()
{
    return $this->hasMany('App\Models\AvailabilityTiming', 'user_id', 'id');
}
public function ratingTo()
{
    return $this->hasMany('App\Models\Review', 'rating_to', 'id');
}
public function featured()
{
    return $this->hasOne('App\Models\FeaturedHost', 'user_id', 'id');
}
// public function firstLesson()
// {
//     return $this->hasOne('App\Models\BookedLesson', 'teacher_id', 'id')->select('id','lesson_start_time','lesson_end_time')->orderBy('created_at','asc');
// }
// public function lastLesson()
// {
//     return $this->hasOne('App\Models\BookedLesson', 'teacher_id', 'id')->select('id','lesson_start_time','lesson_end_time')->orderBy('created_at','dsc');
// }
}
