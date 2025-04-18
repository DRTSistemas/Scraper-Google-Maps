<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FAQRCode\Google2FA;
use Illuminate\Validation\ValidationException;

use App\User;

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

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function redirectTo()
    {
        if(Auth::user()->level == 1) {
            return '/admin';
        }

        return '/home';
    }

    public function login(Request $request)
    {
        $input = $request->all();

        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);

        $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        if(auth()->attempt(array($fieldType => $input['username'], 'password' => $input['password'])))
        {
            $google2fa = new Google2FA();

            $user = auth()->user();
            if($user->google2fa_secret) {

                $request->session()->put('2fa:user:id', $user->id);
                $request->session()->put('2fa:user:credentials', $request->only($fieldType, 'password'));
                $request->session()->put('2fa:auth:attempt', true);
                $otp_secret = $user->google2fa_secret;
                $google2fa->getCurrentOtp($otp_secret);

                auth()->logout();
                return redirect()->route('2fa');
            } else {
                return redirect()->route('home');
            }
        }else{
            return redirect()->route('login')
                ->with('error','Endereço de e-mail e senha estão errados.');
        }
    }

    public function login2fa(Request $request)
    {
        $user_id = $request->session()->get('2fa:user:id');
        if(!$user_id){
            return redirect()->route('login');
        }
        return view('auth.2fa');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'one_time_password' => 'required|string',
        ]);

        $user_id = $request->session()->get('2fa:user:id');
        $credentials = $request->session()->get('2fa:user:credentials');
        $attempt = $request->session()->get('2fa:auth:attempt', false);

        if (!$user_id || !$attempt) {
            return redirect()->route('login');
        }

        $user = User::find($user_id);

        if (!$user) {
            return redirect()->route('login');
        }

        $google2fa = new Google2FA();
        $otp_secret = $user->google2fa_secret;

        if (!$google2fa->verifyKey($otp_secret, $request->one_time_password)) {
            throw ValidationException::withMessages([
             'one_time_password' => [__('A senha de uso único é inválida.')],
            ]);
        }

        $guard = config('auth.web.guard');        
        if ($attempt) {
            $guard = config('auth.web.attempt_guard', $guard);
        }
        
        if (auth()->attempt($credentials, true)) {
            $request->session()->remove('2fa:user:id');
            $request->session()->remove('2fa:user:credentials');
            $request->session()->remove('2fa:auth:attempt');
        
            return redirect()->route('home');
        }
        
        return redirect()->route('login')->withErrors([
            'password' => __('As credenciais fornecidas estão incorretas.'),
        ]);
    }

}
