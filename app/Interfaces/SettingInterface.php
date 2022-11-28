<?php

namespace App\Interfaces;


use Illuminate\Http\Request;
use App\Http\Requests\Settings\GetPagesRequest;
use App\Http\Requests\Settings\ContactUsRequest;
use App\Http\Requests\Settings\UserChangeEmailRequest;
use App\Http\Requests\Settings\TokenRequest;

use App\Http\Requests\Settings\UserChangePasswordRequest;



interface SettingInterface
{
    public function getPages(GetPagesRequest $request);
    public function changeEmail(UserChangeEmailRequest $request);
    public function changePassword(UserChangePasswordRequest $request);
    public function getNotification(Request $request);

    public function updateUnreadCount();
  


    
}
