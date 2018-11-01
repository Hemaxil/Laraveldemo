<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Contracts\Auth\Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Facebook\Facebook as Facebook;
use Socialite;
use Illuminate\Http\Request;

use App\User as User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

   public function redirectTo(){
     
    if(Auth::user()->hasRole('customer')){
        return '/home';
    
    }else
    {
        return '/admin/';
    }
}

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showUserLoginForm()
    {   

       $configuration='App\Configuration'::where('status','1')->pluck('conf_value','conf_key');
        
        return view('auth.user_login',['configurations'=>$configuration]);
    }

   // public function redirectToProvider()
   //  {
   //      return Socialite::driver('facebook')->redirect(['verify' => '/vendor/guzzlehttp/guzzle/src/cacert.pem']);
   //  }

   

}


//modified RedirectUsers.php for page redirection
//modified logout function