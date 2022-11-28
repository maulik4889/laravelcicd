<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ForgotPasswordRequest;
use App\Http\Requests\User\SocialLoginRequest;
use App\Http\Requests\User\UserChangePasswordRequest;
use App\Http\Requests\User\UserLoginRequest;
use App\Http\Requests\User\UserProfileImageRequest;
use App\Http\Requests\User\UserProfileRequest;
use App\Http\Requests\User\UserResendVerifyRequest;
use App\Http\Requests\User\UserSignupRequest;
use App\Http\Requests\ReportUser\ReportUserRequest;
use App\Http\Traits\CommonTrait;
use App\Http\Traits\UserTrait;
use App\Interfaces\UserInterface;
use App\Mail\SignupEmail;
use App\Mail\ForgotPasswordEmail;
use App\Models\ActivityLog;

use App\Models\Page;
use App\Models\Role;
use App\User;
use Config;
use DB;
use Hash;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Image;
use Lcobucci\JWT\Parser;
use Mail;
use Response;

class UsersController extends Controller implements UserInterface
{
    use CommonTrait, UserTrait;


    /**
     * @return \Illuminate\Http\JsonResponse
     *
     *
     *  @SWG\Post(
     *   path="/user/signUp",
     *   summary="signUp",
     *   consumes={"multipart/form-data"},
     *   produces={"application/json"},
     *   tags={"User"},
     * 
     *   @SWG\Parameter(
     *     name="email",
     *     in="formData",
     *     required=true,
     *     type="string",
     *     description = "email",
     *   ),
     *   @SWG\Parameter(
     *     name="password",
     *     in="formData",
     *     required=true,
     *     type="string",
     *     description = "password",
     *   ),
     *  @SWG\Parameter(
     *     name="password_confirmation",
     *     in="formData",
     *     required=true,
     *     type="string",
     *     description = "password_confirmation",
     *   ),
     *  @SWG\Parameter(
     *     name="type",
     *     in="formData",
     *     required=true,
     *     type="integer",
     *     description = "type",
     *   ),
     *   @SWG\Parameter(
     *     name="termandC",
     *     in="formData",
     *     required=true,
     *     type="integer",
     *     description = "term conditions",
     *   ),
     *    @SWG\Parameter(
     *     name="privacy_policy",
     *     in="formData",
     *     required=true,
     *     type="integer",
     *     description = "subscribed_privacy_policy",
     *   ),
     *   @SWG\Response(response=200, description="Success"),
     *   @SWG\Response(response=400, description="Failed"),
     *   @SWG\Response(response=405, description="Undocumented data"),
     *   @SWG\Response(response=500, description="Internal server error")
     * )
     *
     */

    // this function is used for normal signup 
    public function signUp(UserSignupRequest $request)
    {     
        $requested_data = $request->all();
       
            $array['role_id'] = 2;
            $array['password'] = bcrypt($requested_data['password']);
            $array['name'] = $requested_data['name'];

            $array['email'] = $requested_data['email'];
            $array['verify_token'] = $this->getverificationCode();
         
            $array['created_at'] = time();
            $array['updated_at'] = time();
            $user = User::create($array);

        if ($user) {
            Mail::to($requested_data['email'])->send(new SignupEmail($user));
            //Mail::to($user->email)->send(new SignupEmail($user));
            $data = \Config::get('success.user_created');
            $data['data'] = (object) [];
        } else {
            $data = \Config::get('error.user_created');
            $data['data'] = (object) [];
        }
        return Response::json($data);
    }

    public function verifyUser(Request $request ){
        $user = User::where('verify_token', $request->token)->select('id','secondary_email')->first();
        if($user)
        {
                $user->update([
                    'status' => '1',
                    'verify_token' => '',
                    
                ]);
                $data = \Config::get('success.user_created');
                $data['data'] =1;  
            } 
            else{
             
                $data = \Config::get('success.user_created');
                $data['data'] =2; 
                }
                return Response::json($data);

      

    }


    /**
     * @return \Illuminate\Http\JsonResponse
     *
     *
     *  @SWG\Post(
     *   path="/user/socialLogin",
     *   summary="socialLogin",
     *   consumes={"multipart/form-data"},
     *   produces={"application/json"},
     *   tags={"User"},
     *  @SWG\Parameter(
     *     name="name",
     *     in="formData",
     *     required=true,
     *     type="string",
     *     description = "name",
     *   ),
     *   @SWG\Parameter(
     *     name="email",
     *     in="formData",
     *     required=true,
     *     type="string",
     *     description = "email",
     *   ),
     *   @SWG\Parameter(
     *     name="device_type",
     *     in="formData",
     *     required=true,
     *     type="string",
     *     description = "Please enter (IOS / ANDROID) ",
     *   ),
     *  @SWG\Parameter(
     *     name="signup_type",
     *     in="formData",
     *     required=true,
     *     type="string",
     *     description = "Please enter (facebook / gmail) ",
     *   ),
     *  @SWG\Parameter(
     *     name="social_id",
     *     in="formData",
     *     required=true,
     *     type="string",
     *     description = "Please enter social id",
     *   ),
     *  @SWG\Parameter(
     *     name="image",
     *     in="formData",
     *     required=false,
     *     type="string",
     *     description = "Please enter image path",
     *   ),
     *   
     *   @SWG\Response(response=200, description="Success"),
     *   @SWG\Response(response=400, description="Failed"),
     *   @SWG\Response(response=405, description="Undocumented data"),
     *   @SWG\Response(response=500, description="Internal server error")
     * )
     *
     */

    public function socialLogin(SocialLoginRequest $request)
    {
        $requested_data = $request->all();

        $user = User::where('email', '=', request('email'))->first();
        //Now log in the user if exists
        if ($user != null) {

            switch ($user->status) { # if blocked by admin

                case 2:
                    Auth::logout();
                    $data = \Config::get('error.account_blocked_admin');
                    $data['data'] = (object) [];
                    return Response::json($data);
                    break;
            }

            DB::table('oauth_access_tokens')->where('user_id', $user->id)->update(['revoked' => true]); # logout

            Auth::loginUsingId($user->id); # login
          

            $user->device_type = isset($requested_data['device_type']) ? $requested_data['device_type'] : '';
            $user->signup_type = isset($requested_data['signup_type']) ? $requested_data['signup_type'] : '';
            $user->social_id = isset($requested_data['social_id']) ? $requested_data['social_id'] : '';
            $user->image = isset($requested_data['image']) ? $requested_data['image'] : '';
            $user->save();
            $remember_me = isset($requested_data['remember_me']) ? $requested_data['remember_me'] : false;
            $user_last_login = User::where('id', $user->id)
                ->update(['current_login' => time(), 'last_login' => Auth::user()->current_login]);
            return Response::json([
                'status' => 200,
                'role_id' => $user->role_id,
                'profile_status' => $user->status,
                'email' => $user->email,
                'profile_steps'=>Auth::user()->profile_steps,
                'profile_image'=>Auth::user()->image,
                'subscription_id'=>Auth::user()->subscription_id,
                'bank_verified'=>Auth::user()->bank_verified,
                'user_token'=>$user->createToken(env("APP_NAME"))->accessToken
                ])->header('access_token', $user->createToken(env("APP_NAME"))->accessToken);
      
        } else {
            $array = [];
            if($requested_data['type']== ''){
                $data['status']=400;
                $data['message']='Account not found. Have you created one? You can do so via the sign up button';
                return Response::json($data);

            } 
            if($requested_data['email']==''){
                $data['status']=400;
                $data['message']='Your facebook account is not linked to an email address. Please use an account that includes your email addresss';
                return Response::json($data);
            }
            else{
            if ($requested_data['type'] == 1) {
                $name = "student";

                $namee = $requested_data['name'];
                $email = $requested_data['email'];

                 $curl = curl_init();
        
                curl_setopt_array($curl, array(
                  CURLOPT_URL => "https://api.mailerlite.com/api/v2/groups/111206527/subscribers",
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => "",
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 30,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => "POST",
                  CURLOPT_POSTFIELDS => "{\"email\":\"$email\", \"name\": \"$namee\", \"fields\": {\"company\": \"MailerLite\"}}",
                  CURLOPT_HTTPHEADER => array(
                    "content-type: application/json",
                    "x-mailerlite-apikey: bd9b896677d244ba5745e77b059cc84f"
                  ),
                ));
                
                $response = curl_exec($curl);
                $err = curl_error($curl);
                
                curl_close($curl);
        
        
                    } else {
                        $name = "teacher";
        
        
        
                        $namee=  $requested_data['name'];
                        $email= $requested_data['email'];
                        $curl = curl_init();
                
                curl_setopt_array($curl, array(
                  CURLOPT_URL => "https://api.mailerlite.com/api/v2/groups/111206524/subscribers",
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => "",
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 30,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => "POST",
                  CURLOPT_POSTFIELDS => "{\"email\":\"$email\", \"name\": \"$namee\", \"fields\": {\"company\": \"MailerLite\"}}",
                  CURLOPT_HTTPHEADER => array(
                    "content-type: application/json",
                    "x-mailerlite-apikey: bd9b896677d244ba5745e77b059cc84f"
                  ),
                ));
                
                $response = curl_exec($curl);
                $err = curl_error($curl);
                
                curl_close($curl);
            }
            $array['role_id']= Role::where('name',$name)->first()->id;
            $array['name'] = $requested_data['name'];
            $check_aleardy_host_url= User::where('host_url',$requested_data['name'])->count();
            if($check_aleardy_host_url==0){
                $array['host_url'] = str_replace(' ', '', strtolower($requested_data['name']));
            }else{
                $array['host_url'] = str_replace(' ', '', strtolower($requested_data['name'])).$check_aleardy_host_url;
            }

            $array['email'] = $requested_data['email'];
            $array['device_type'] = isset($requested_data['device_type']) ? $requested_data['device_type'] : '';
            $array['signup_type'] = isset($requested_data['signup_type']) ? $requested_data['signup_type'] : '';
            $array['social_id'] = isset($requested_data['social_id']) ? $requested_data['social_id'] : '';
            $array['image'] = isset($requested_data['image']) ? $requested_data['image'] : '';
            $array['status'] = 1;
            $array['created_at'] = time();
            $array['updated_at'] = time();

            $user = User::create($array);
            Auth::loginUsingId($user->id);
            $remember_me = isset($requested_data['remember_me']) ? $requested_data['remember_me'] : false;
             $user_last_login = User::where('id', $user->id)
                ->update(['current_login' => time(), 'last_login' => Auth::user()->current_login]);

                
            return Response::json([
            'status' => 200,
                'role_id' => $user->role_id,
                'profile_status' => $user->status,
                'email' => $user->email,
                'profile_steps'=>Auth::user()->profile_steps,
                'profile_image'=>Auth::user()->image,
                'user_token'=>$user->createToken(env("APP_NAME"))->accessToken,
                'subscription_id'=>Auth::user()->subscription_id,

                ])->header('access_token', $user->createToken(env("APP_NAME"))->accessToken);
        }
    }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     *
     *
     *  @SWG\Post(
     *   path="/user/login",
     *   summary="login",
     *   consumes={"multipart/form-data"},
     *   produces={"application/json"},
     *   tags={"User"},
     *   @SWG\Parameter(
     *     name="email",
     *     in="formData",
     *     required=true,
     *     type="string",
     *     description = "email",
     *   ),
     *   @SWG\Parameter(
     *     name="password",
     *     in="formData",
     *     required=true,
     *     type="string",
     *     description = "password",
     *   ),
     * @SWG\Parameter(
     *     name="device_type",
     *     in="formData",
     *     required=false,
     *     type="string",
     *     description = "IOS/ANDROID",
     *   ),
     *   
     *   @SWG\Response(response=200, description="Success"),
     *   @SWG\Response(response=400, description="Failed"),
     *   @SWG\Response(response=405, description="Undocumented data"),
     *   @SWG\Response(response=500, description="Internal server error")
     * )
     *
     */
    public function login(UserLoginRequest $request)
    {
        $requested_data = $request->all();
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')], request('remember_me'))) {
            $user = Auth::user();
            if($user->role_id==2 || $user->role_id==3){
            $token= $user->createToken(env("APP_NAME"))->accessToken;
           
            $user = $user->update([
                'authentication_token' => $token ,
                'device_type' => isset($requested_data['device_type']) ? $requested_data['device_type'] : '',
                'updated_at' => time()
            ]);
            $user = Auth::user();
            switch ($user->status) {
                case 0:
                    Auth::logout();
                    $data = \Config::get('error.account_not_verified');
                    $data['user_unverified'] = true;
                    $data['email'] = request('email');
                    $data['data'] = (object) [];
                    return Response::json($data);
                    break;
                case 2:
                    Auth::logout();
                    $data = \Config::get('error.account_blocked_admin');
                    $data['data'] = (object) [];
                    return Response::json($data);
                    break;
            }

            $remember_me = isset($requested_data['remember_me']) ? $requested_data['remember_me'] : false;
            $user_last_login = User::where('id', $user->id)
                ->update(['current_login' => time(), 'last_login' => $user->current_login]);

            // $user_activity_login = ActivityLog::updateOrCreate(
            //     ['user_id' => $user->id, 'meta_key' => 'last_login'],
            //     ['user_id' => $user->id, 'meta_key' => 'last_login',
            //         'meta_value' => $user->current_login, 'status' => 1,
            //         'created_at' => time(), 'updated_at' => time()]
            // );
            return Response::json([
                'status' => 200,
                'id'=>$user->id,
                'role_id' => $user->role_id,
                'profile_status' => $user->status,
                'email' => $user->email,
                'profile_steps'=>Auth::user()->profile_steps,
                // 'subscription_id'=>Auth::user()->subscription_id,
                // 'bank_verified'=>Auth::user()->bank_verified,

                'profile_image'=>Auth::user()->image,

                'user_token'=>$user->createToken(env("APP_NAME"))->accessToken
                ])->header('access_token', $user->createToken(env("APP_NAME"))->accessToken);
        }
        else {
            $data = \Config::get('error.invalid_email_password');
            $data['data'] = (object) [];
        } 
    }else {
            $data = \Config::get('error.invalid_email_password');
            $data['data'] = (object) [];
        }
        return Response::json($data);

    }
     /**
     * @return \Illuminate\Http\JsonResponse
     *
     *
     *  @SWG\Post(
     *   path="/user/logout",
     *   summary="logout",
     *   consumes={"multipart/form-data"},
     *   produces={"application/json"},
     *   tags={"User"},
     *   @SWG\Parameter(
     *     name="Authorization",
     *     in="header",
     *     required=true,
     *     description = "Enter Token",
     *     type="string",
     *   ),
     *   @SWG\Response(response=200, description="Success"),
     *   @SWG\Response(response=400, description="Failed"),
     *   @SWG\Response(response=405, description="Undocumented data"),
     *   @SWG\Response(response=500, description="Internal server error")
     * )
     *
     */
    public function logout(Request $request)
    {
        $user = Auth::user()->token();
        $user->revoke();
        if ($user) {
            $data = \Config::get('success.logout');
            $data['data'] = (object) [];
        } else {
            $data['status'] = 400;
            $data['message'] = 'Error';
        }
        return Response::json($data);

    }

    /**
     * @return \Illuminate\Http\JsonResponse
     *
     *
     *  @SWG\Post(
     *   path="/user/resendVerification",
     *   summary="resendVerification",
     *   consumes={"multipart/form-data"},
     *   produces={"application/json"},
     *   tags={"User"},
     *   @SWG\Parameter(
     *     name="email",
     *     in="formData",
     *     required=true,
     *     type="string",
     *     description = "email",
     *   ),   
     *   @SWG\Response(response=200, description="Success"),
     *   @SWG\Response(response=400, description="Failed"),
     *   @SWG\Response(response=405, description="Undocumented data"),
     *   @SWG\Response(response=500, description="Internal server error")
     * )
     *
     */
    public function resendVerification(UserResendVerifyRequest $request)
    {
        $requested_data = $request->all();
        $array['verify_token'] = $this->getverificationCode();
        $array['created_at'] = time();
        $user = User::where('email', $requested_data['email'])->update($array);
        if ($user) {
            $user = User::where('email', $requested_data['email'])->first();
             Mail::to($user->email)->send(new SignupEmail($user));
            $data = \Config::get('success.resend_verification');
            $data['data'] = (object) [];

        } else {
            $data = \Config::get('error.resend_verification');
            $data['data'] = (object) [];
        }
        return Response::json($data);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     *
     *
     *  @SWG\Post(
     *   path="/user/forgotPassword",
     *   summary="forgotPassword",
     *   consumes={"multipart/form-data"},
     *   produces={"application/json"},
     *   tags={"User"},
     *   @SWG\Parameter(
     *     name="email",
     *     in="formData",
     *     required=true,
     *     type="string",
     *     description = "email",
     *   ),   
     *   @SWG\Response(response=200, description="Success"),
     *   @SWG\Response(response=400, description="Failed"),
     *   @SWG\Response(response=405, description="Undocumented data"),
     *   @SWG\Response(response=500, description="Internal server error")
     * )
     *
     */
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $requested_data = $request->all();
        $forgot_password_code = $this->getverificationCode();
        $check_user = User::where(['email' => $requested_data['email']])->first();

        if (!empty($check_user)) {
            User::where('email', $requested_data['email'])->update(array('forgot_password_token' => $forgot_password_code)); // update the record in the DB.

            $email = $requested_data['email'];
            $admin_email = Config::get('variable.ADMIN_EMAIL');
            $frontend_url = Config::get('variable.FRONTEND_URL');
            $name = $check_user->name;
            
             Mail::to($check_user->email)->send(new ForgotPasswordEmail($check_user));
            if (count(Mail::failures()) > 0) {
                $data = \Config::get('error.error_sending_email');
                $data['data'] = (object) [];
            } else {
                $data = \Config::get('success.send_forgot_password_link');
                $data['data'] = (object) [];
            }
        } else {
            $data = \Config::get('error.send_forgot_password_link');
            $data['data'] = (object) [];
        }
        return Response::json($data);

    }


     /**
     * @return \Illuminate\Http\JsonResponse
     *
     *
     *  @SWG\Post(
     *   path="/user/uploadProfileImage",
     *   summary="uploadImage",
     *   consumes={"multipart/form-data"},
     *   produces={"application/json"},
     *   tags={"User"},
     *   @SWG\Parameter(
     *     name="Authorization",
     *     in="header",
     *     required=true,
     *     description="Enter Token",
     *     type="string",
     *   ),
     *  @SWG\Parameter(
     *     name="image",
     *     in="formData",
     *     required=true,
     *     type="file"
     *   ),  
     *   @SWG\Response(response=200, description="Success"),
     *   @SWG\Response(response=400, description="Failed"),
     *   @SWG\Response(response=405, description="Undocumented data"),
     *   @SWG\Response(response=500, description="Internal server error")
     * )
     *
     */

    public function uploadProfileImage(Request $request)
    {
        $requested_data = $request->all();
        $user = Auth::user();
        // check file extension
        $allowed = ['jpeg', 'png', 'JPEG','JPG','jpg','PNG'];
        $filename = $_FILES['image']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
       // return $ext;
        if (!in_array($ext, $allowed)) {
            $data = \Config::get('error.invalid_file_format');
            $data['data'] = (object) [];
            return Response::json($data);
        }
        // check file sizeUserProfileImageRequest5242880
        if ($_FILES['image']['size'] >10485760 ) {
            $data = \Config::get('error.file_too_largeUserProfileImageRequest');
            $data['message']="Unable to upload. File over 10MB";
            $data['status']=400;
            $data['data'] = (object) [];
            return Response::json($data);
        }

        //upload file
        $dynamic_name = time() . '-' . $this->imageDynamicName() . '.' . $ext;
        $image = $request->file('image')->storeAs('public/user', $dynamic_name);

        if ($image) {
            $image_name = explode('/', $image);
            $saved_Image = $this->userImageVersions($image_name[2]);
            if ($saved_Image) {
                // unlink file from directory
                if ($user->image != '' && $user->image != null) {
                    $previous_image_path = storage_path('app/public/user/') . $user->image;
                    $previous_image_path_thumb = storage_path('app/public/user/thumb/') . $user->image;

                    if (file_exists($previous_image_path)) {
                        unlink($previous_image_path);
                    }
                    if (file_exists($previous_image_path_thumb)) {
                        unlink($previous_image_path_thumb);
                    }
                }

                // save file name in user account
                $updateUser = User::where('id', $user->id)->update(['image' => $image_name[2]]);

                if ($updateUser) {
                    // $server_url = Config::get('variable.SERVER_URL');
                    // if (!empty($image_name[2]) && file_exists(storage_path() . '/app/public/user/thumb/' . $image_name[2])) {
                    //     $path = $server_url . '/storage/user/thumb/' . $image_name[2];
                    // } else {
                    //     $path = $server_url . '/images/user-default.png';
                    // }
                    $data = \Config::get('success.uploaded_profile_image');

                    $data['image'] = "https://dev.matutto.com/backend/storage/user/thumb/$image_name[2]";
                    return Response::json($data);
                } else {
                    $data = \Config::get('error.uploaded_profile_image');
                    return Response::json($data);
                }
            } else {
                $data = \Config::get('error.uploaded_profile_image');
                return Response::json($data);
            }
        }
    
    }
    
    public function currentLogin(){
    $current_login_date = date('y-m-d', Auth::user()->current_login);
    $today_date = date('y-m-d', time());
    if($current_login_date != $today_date)
        $user_last_login = User::where('id', Auth::user()->id)
        ->update(['current_login' => time(), 'last_login' => Auth::user()->current_login]);
    }
     public function saveProfile(Request $request){
                    $date=date('m/d/y',strtotime($request->dob));

        $save_profile = User::where('id',Auth::user()->id)->update(['dob'=>$date,'nationality'=>$request->nationality,'profile_steps'=>2,'moving_reason'=>$request->moving_reason]);
        if ($save_profile) {
            // $server_url = Config::get('variable.SERVER_URL');
            // if (!empty($image_name[2]) && file_exists(storage_path() . '/app/public/user/thumb/' . $image_name[2])) {
            //     $path = $server_url . '/storage/user/thumb/' . $image_name[2];
            // } else {
            //     $path = $server_url . '/images/user-default.png';
            // }
            $data = \Config::get('success.user_profile');

            return Response::json($data);
        } else {
            $data = \Config::get('error.user_profile');
            return Response::json($data);
        }
     }

     public function getProfile(Request $request)
     { 
         $get_profile = User::where('id', $request['data']['id'])->first();
         $date = date('m/d/y', $get_profile->dob);
       
         if ($get_profile) {
             $data = \Config::get('success.profile_fetched');
             $data['data'] = $get_profile;
       
             $data['data']['dob'] = $date;
        
            
 
         } else {
             $data = \Config::get('error.profile_not_fetched');
             $data['data'] = (object) [];
         }
         return Response::json($data);
     }
  
}
    
    


   
    

   






