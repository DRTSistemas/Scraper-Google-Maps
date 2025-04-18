<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use App\UserPlan;
use App\Country;
// use Authy\AuthyApi as AuthyApi;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers {
        // change the name of the name of the trait's method in this class
        // so it does not clash with our own register method
        register as registration;
    }

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => ['required', 'regex:/^\S*$/u', 'string', 'min:5', 'unique:users'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'indication_id' => 'string',
            'country_code' => 'required',
            'phone_number' => 'required'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        /*
        $indication_id = User::where('username', $data['indication_id'])->first();

        if (empty($indication_id)) {
            return redirect()->route('login')->withError("Indication Code doesn't exist");
        }
        */

        $password = Hash::make($data['password']);
        $api_token = Str::random(60);

        /*
        $userSuporte = DB::connection('suporte')->table('users')
            ->insertGetId(
                [
                    'username' => $data['username'],
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => $password,
                    'api_token' => $api_token,
                ]
            );

        DB::connection('suporte')->table('role_user')
            ->insert(
                [
                    'user_id' => $userSuporte,
                    'role_id' => 2
                ]
            );
        */

        return User::create([
            'username' => $data['username'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $password,
            'api_token' => $api_token,
            //'indication_id' => $indication_id->id,
            'country_code' => $data['country_code'],
            'phone_number' => $data['phone_number'],
            //'google2fa_secret' => $data['google2fa_secret'],
        ]);

        // $authyUser = $authyApi->registerUser(
        //     $newUser->email,
        //     $newUser->phone_number,
        //     $newUser->country_code
        // );
        // if ($authyUser->ok()) {
        //     $newUser->authy_id = $authyUser->id();
        //     $newUser->save();
        //     $request->session()->flash(
        //         'status',
        //         "User created successfully"
        //     );

        //     $sms = $authyApi->requestSms($newUser->authy_id);
        //     DB::commit();
        //     return redirect()->route('user-show-verify');
        // } else {
        //     $errors = $this->getAuthyErrors($authyUser->errors());
        //     DB::rollback();
        //     return view('newUser', ['errors' => new MessageBag($errors)]);
        // }
    }

    public function showRegistrationForm($code = null)
    {
        /*
        if (empty($code)) {
            return redirect()->route('login');
        }
        
        $check = User::where('username', $code)->first();

        if (empty($check)) {
            return redirect()->route('login');
        }
        

        $activePlan = UserPlan::where([['user_id', $check->id], ['status', 1]])->get();
        
        if ($activePlan->isEmpty() AND $check->level == 0) {
            return redirect()->route('login')->withError('User not active');
        }
        */

        return view('auth.register', ['countries' => Country::select('nicename', 'phonecode')->get()]);
    }
}
