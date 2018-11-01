<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Contracts\Auth\Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Facebook\Facebook as Facebook;
use Socialite;
use Illuminate\Http\Request;

use App\User as User;

class SocialLoginController extends Controller
{
    use AuthenticatesUsers;

    

     public function redirectToProvider()
    {
        
        return Socialite::driver('facebook')->redirect();
    }
    
    public function handleProviderCallback()
    { 
   
        $user = Socialite::driver('facebook')->user();
        $findUser=User::where('email',$user->email)->first();
       
        if($findUser){
            Auth::loginUsingId($findUser->id);

            
        }else{
             $user_register=User::create(['name'=>$user->name,'password'=>bcrypt('abcd1234'),'fb_token'=>$user->token]);
             $user_register->save();
        }
       
       return redirect()->route('home');    // $user->token;
    }

  
}
