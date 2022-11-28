<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\GetPagesRequest;
use App\Http\Requests\Settings\UserChangeEmailRequest;
use App\Http\Requests\Settings\UserChangePasswordRequest;
use App\Http\Traits\CommonTrait;
use App\Http\Traits\UserTrait;
use App\Interfaces\SettingInterface;
use App\Mail\ChangeEmail;

use App\Models\DeletedUser;
use App\Models\Notification;
use App\Models\Page;

use App\User;
use Auth;
use Config;
use Datetime;
use DateTimeZone;
use File;
use Hash;
use Illuminate\Http\Request;
use Mail;
use Response;

class SettingsController extends Controller implements SettingInterface
{
    use CommonTrait, UserTrait;
   
    /**
     * @return \Illuminate\Http\JsonResponse
     *
     *
     *  @SWG\Get(
     *   path="/settings/getPages",
     *   summary="Get page information",
     *   consumes={"multipart/form-data"},
     *   produces={"application/json"},
     *   tags={"Settings"},
     * @SWG\Parameter(
     *     name="Authorization",
     *     in="header",
     *     required=true,
     *     description = "Enter Token",
     *     type="string",
     *   ),
     * @SWG\Parameter(
     *     name="meta_key",
     *     in="query",
     *     required=true,
     *     type="string",
     *     description = "for about us page meta_key = about_us, for terms and conditions meta_key = term, for privacy policy meta_key=privacy_policy"
     *   ),
     *   @SWG\Response(response=200, description="Success"),
     *   @SWG\Response(response=400, description="Failed"),
     *   @SWG\Response(response=405, description="Undocumented data"),
     *   @SWG\Response(response=500, description="Internal server error")
     * )
     *
     */

    public function getPages(GetPagesRequest $request)
    {
        $requested_data = $request->all();
        $getPages = Page::where('meta_key', $requested_data['meta_key'])->latest()->first();
        if ($getPages) {
            $data = \Config::get('success.get_pages');
            $data['data'] = $getPages;
        } else {
            $data = \Config::get('error.get_pages');
            $data['data'] = (object) [];
        }
        return Response::json($data);

    }

    public function unreadMessage()
    {
        $unread_count = Participant::where('receiver_id', Auth::user()->id)->where('delivered_status', 0)->count();
        $data["data"] = $unread_count;
        $data["status"] = 200;
        $data["message"] = 'success';
        return Response::json($data);
    }
    public function updateUnreadCount()
    {
        $unread_count = Participant::where('receiver_id', Auth::user()->id)->update(['delivered_status' => 1]);
        $data["data"] = $unread_count;
        $data["status"] = 200;
        $data["message"] = 'success';
        return Response::json($data);
    }

       /**
     * @return \Illuminate\Http\JsonResponse
     *
     *
     *  @SWG\Post(
     *   path="/settings/changeEmail",
     *   summary="change email",
     *   consumes={"multipart/form-data"},
     *   produces={"application/json"},
     *   tags={"Settings"},
     * @SWG\Parameter(
     *     name="Authorization",
     *     in="header",
     *     required=true,
     *     description="Enter Token",
     *     type="string",
     *   ),
     *   @SWG\Parameter(
     *     name="old_email",
     *     in="formData",
     *     required=true,
     *     type="string",
     *     description = "old email",
     *   ),
     * @SWG\Parameter(
     *     name="new_email",
     *     in="formData",
     *     required=true,
     *     type="string",
     *     description = "new email",
     *   ),
     * @SWG\Parameter(
     *     name="new_email_confirmation",
     *     in="formData",
     *     required=true,
     *     type="string",
     *     description = "new email confirmation",
     *   ),
     *   @SWG\Response(response=200, description="Success"),
     *   @SWG\Response(response=400, description="Failed"),
     *   @SWG\Response(response=405, description="Undocumented data"),
     *   @SWG\Response(response=500, description="Internal server error")
     * )
     *
     */

    public function changeEmail(UserChangeEmailRequest $request)
    {
        $hashedPassword = Auth::user()->password;
        if (Hash::check($request->password, $hashedPassword)) {

            $oldEmail = $request->old_email;
            $newEmail = $request->new_email;
            $email = Auth::user()->email;
            $user = Auth::user();

            if ($oldEmail = Auth::user()->email) {

                $user = User::find(Auth::user()->id);
                $user->update(
                    ['secondary_email' => $newEmail,
                        'verify_token' => $this->getverificationCode(),
                    ]
                );
                if ($user) {

                    Mail::to($newEmail)->send(new ChangeEmail($user));

                    $data = \Config::get('success.update_email');
                    $data['data'] = (object) [];
                } else {
                    $data = \Config::get('error.update_email');
                    $data['data'] = (object) [];
                }
            } else {
                $data = \Config::get('error.wrong_old_email');
                $data['data'] = (object) [];
            }
            return Response::json($data);
        } else {
            $data['status'] = 400;
            $data['message'] = "Password is incorrect";
            $data['kkjkj'] = Auth::user()->signup_type;
            return Response::json($data);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     *
     *
     *  @SWG\Post(
     *   path="/settings/changePassword",
     *   summary="Change Password",
     *   consumes={"multipart/form-data"},
     *   produces={"application/json"},
     *   tags={"Settings"},
     *   @SWG\Parameter(
     *     name="Authorization",
     *     in="header",
     *     required=true,
     *     description="Enter Token",
     *     type="string",
     *   ),
     *   @SWG\Parameter(
     *     name="old_password",
     *     in="formData",
     *     required=true,
     *     type="string",
     *     description = "old password",
     *   ),
     *   @SWG\Parameter(
     *     name="new_password",
     *     in="formData",
     *     required=true,
     *     type="string",
     *     description = "new password",
     *   ),
     * @SWG\Parameter(
     *     name="new_password_confirmation",
     *     in="formData",
     *     required=true,
     *     type="string",
     *     description = "new password confirmation",
     *   ),
     *   @SWG\Response(response=200, description="Success"),
     *   @SWG\Response(response=400, description="Failed"),
     *   @SWG\Response(response=405, description="Undocumented data"),
     *   @SWG\Response(response=500, description="Internal server error")
     * )
     *
     */

    public function changePassword(UserChangePasswordRequest $request)
    {
        $oldPassword = $request->old_password;
        $newPassword = $request->new_password;
        $hashedPassword = Auth::user()->password;
        if (Hash::check($oldPassword, $hashedPassword)) {
            $user = User::find(Auth::user()->id)
                ->update(
                    ['password' => Hash::make($newPassword)]
                );
            if ($user) {
                $data = \Config::get('success.update_password');
                $data['data'] = (object) [];
            } else {
                $data = \Config::get('error.update_password');
                $data['data'] = (object) [];
            }
        } else {
            $data = \Config::get('error.wrong_old_password');
            $data['data'] = (object) [];
        }
        return Response::json($data);
    }
    /**
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *   path="/settings/getNotification",
     *   summary="Get Notifications",
     *   produces={"application/json"},
     *   tags={"Notification"},
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
    public function getNotification(Request $request)
    {
        $get_my_notifications = Notification::where('receiver_id', $request['data']['id'])
            ->with('sender', 'booklessons.lessons')->orderBy('created_at', 'desc')
            ->paginate(\Config::get('variable.page_per_record'));
        if ($get_my_notifications) {
            $data = \Config::get('success.get_my_notifications');
            $data['data'] = $get_my_notifications;
            return Response::json($data);
        }
    }
 
}
