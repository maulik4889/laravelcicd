<?php

namespace App\Interfaces;

use App\Http\Requests\User\ForgotPasswordRequest;
use App\Http\Requests\User\UserChangePasswordRequest;
use App\Http\Requests\User\UserLoginRequest;
use App\Http\Requests\User\UserProfileImageRequest;
use App\Http\Requests\User\UserResendVerifyRequest;
use App\Http\Requests\User\UserSignupRequest;
use App\Http\Requests\User\UserProfileRequest;
use App\Http\Requests\User\SocialLoginRequest;
use App\Http\Requests\ReportUser\ReportUserRequest;
use Illuminate\Http\Request;

interface UserInterface
{
    public function signUp(UserSignupRequest $request);
    public function login(UserLoginRequest $request);
    public function logout(Request $request);
    public function resendVerification(UserResendVerifyRequest $request);
    public function forgotPassword(ForgotPasswordRequest $request);
    public function socialLogin(SocialLoginRequest $request);
    public function uploadProfileImage(Request $request);
    public function currentLogin();
    public function verifyUser(Request $request );
    public function saveProfile(Request $request);

    public function getProfile(Request $request);

}
