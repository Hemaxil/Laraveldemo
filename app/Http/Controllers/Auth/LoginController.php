<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Spatie\Permission\Traits\HasRoles;
use Facebook\Facebook as Facebook;
use Illuminate\Http\Request;
use Input;
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

    public function loginFacebook(Request $request){
        session_start();
        $request->session()->regenerate();
        $fb = new Facebook([
          'app_id' => config('facebook.config.app_id'),
          'app_secret' => config('facebook.config.app_secret'),
          'persistent_data_handler'=>'session'
          ]);

        $helper = $fb->getRedirectLoginHelper();
        $permissions = ['email']; // Optional permissions
        
        $loginUrl = $helper->getLoginUrl(url('facebook_login/callback'), $permissions);
    return redirect($loginUrl);
}
public function loginFacebookCallback(Request $request){
    session_start();
    $fb = new Facebook([
          'app_id' => config('facebook.config.app_id'),
          'app_secret' => config('facebook.config.app_secret'),
          'persistent_data_handler'=>'session'
          ]);

$helper = $fb->getRedirectLoginHelper();

try {
  $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
    return redirect()->route('user.login')->withErrors('Graph returned an error');
  //echo 'Graph returned an error: ' . $e->getMessage();
  //exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
    return redirect()->route('user.login')->withErrors('Facebook SDK returned an error');
  
  // When validation fails or other local issues
  // echo 'Facebook SDK returned an error: ' . $e->getMessage();
  // exit;
}

if (! isset($accessToken)) {
  if ($helper->getError()) {
    header('HTTP/1.0 401 Unauthorized');
    echo "Error: " . $helper->getError() . "\n";
    echo "Error Code: " . $helper->getErrorCode() . "\n";
    echo "Error Reason: " . $helper->getErrorReason() . "\n";
    echo "Error Description: " . $helper->getErrorDescription() . "\n";
  } else {
    header('HTTP/1.0 400 Bad Request');
    echo 'Bad request';
  }
  exit;
}

// Logged in
echo '<h3>Access Token</h3>';
var_dump($accessToken->getValue());

// The OAuth 2.0 client handler helps us manage access tokens
$oAuth2Client = $fb->getOAuth2Client();

// Get the access token metadata from /debug_token
$tokenMetadata = $oAuth2Client->debugToken($accessToken);
echo '<h3>Metadata</h3>';
var_dump($tokenMetadata);

// Validation (these will throw FacebookSDKException's when they fail)
$tokenMetadata->validateAppId(config('facebook.config.app_id')); // Replace {app-id} with your app id
// If you know the user ID this access token belongs to, you can validate it here
//$tokenMetadata->validateUserId('123');
$tokenMetadata->validateExpiration();

if (! $accessToken->isLongLived()) {
  // Exchanges a short-lived access token for a long-lived one
  try {
    $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
  } catch (Facebook\Exceptions\FacebookSDKException $e) {
    echo "<p>Error getting long-lived access token: " . $e->getMessage() . "</p>\n\n";
    exit;
  }

  echo '<h3>Long-lived</h3>';
  var_dump($accessToken->getValue());
}


session(['fb_access_token'=>(string)$accessToken]);

dd($accessToken);

}
      


    

}


//modified RedirectUsers.php for page redirection
//modified logout function