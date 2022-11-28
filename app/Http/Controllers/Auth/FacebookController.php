<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use App\UserRole;
use Auth;
use Socialite;
use Illuminate\Http\Request;

class FacebookController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToFacebook($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleFacebookCallback(Request $request,$provider)
    {
        if (!$request->has('code') || $request->has('denied')) {
            return redirect('/login');
        }
        $userSocial = Socialite::driver($provider)->stateless()->user();
        $users = User::where(['email' => $userSocial->getEmail()])->first();
        $role = UserRole::where('slug', 'retailer')->select('id')->first();
        if ($users) {
            Auth::login($users);
            return redirect('retailer/profile');
        } else {
            $user = User::create([
                'email' => $userSocial->getEmail(),
                'image' => $userSocial->getAvatar(),
                'facebook_id' => $userSocial->getId(),
                'fullname'=>$userSocial->getName(),
                'role_id'=> $role->id
                //'provider' => $provider,
            ]);
            $users = User::where(['email' => $userSocial->getEmail()])->first();
            Auth::login($users);
            if(Auth::user()->subscribed_term_conditions==2){
                return redirect('retailer/dashboard');
            }else{
                return view('retailer.profile');
            }
        
    
           
        


        /* try {
    $user = Socialite::driver('facebook')->user();
    $create['email'] = $user->getEmail();
    $create['facebook_id'] = $user->getId();

    $userModel = new User;
    $createdUser = $userModel->addNew($create);
    Auth::loginUsingId($createdUser->id);

    return redirect()->route('home');

    } catch (Exception $e) {
    dd($e);
    // return redirect('auth/facebook');

    }*/
    }
}
}

