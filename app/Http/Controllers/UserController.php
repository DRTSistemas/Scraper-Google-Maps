<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\disabled2FA;
use GuzzleHttp\Client;

class UserController extends BaseController
{

    public function index(User $model)
    {
        if($this->checkAdmin()) {
            return redirect()->route('admin.index');
        }

        return view('users.index', ['users' => $model->paginate(15)]);
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(UserRequest $request, User $model)
    {
        $model->create($request->merge(['password' => Hash::make($request->get('password'))])->all());

        return redirect()->route('user.index')->withStatus(__('User successfully created.'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(UserRequest $request, User  $user)
    {
        $user->update(
            $request->merge(['password' => Hash::make($request->get('password'))])
                ->except([$request->get('password') ? '' : 'password']
        ));

        return redirect()->route('user.index')->withStatus(__('User successfully updated.'));
    }

    public function destroy(User  $user)
    {
        $user->delete();

        return redirect()->route('user.index')->withStatus(__('User successfully deleted.'));
    }

    /*
    public function formDisabled2FA()
    {
        $codeDisabled = rand(100000, 999999);
        $user = Auth::user();
        $user->code_disabled2fa = $codeDisabled;
        $user->save();

        Mail::to(Auth::user()->email)->send(new disabled2FA($codeDisabled));

        return view('google2fa.disabled');
    }

    public function disabled2FA(Request $request)
    {
        if($request->input('code_disabled2fa') == Auth::user()->code_disabled2fa) {
            $user = Auth::user();
            $user->google2fa_secret = NULL;
            $user->disabled_2fa = true;
            $user->save();

            return redirect()->route('home');
        }

        return back()->with('status', 'Invalid code. A new code has been sent!');
    }

    public function formEnable2FA()
    {
        session()->forget('google2fa_secret');

        $user = \Auth::user();
        $google2fa = app('pragmarx.google2fa');
        session(['google2fa_secret' => $google2fa->generateSecretKey()]);

        $QR_Image = $google2fa->getQRCodeInline(
            config('app.name'),
            $user->email,
            session('google2fa_secret')
            //$user->google2fa_secret
        );

        return view('google2fa.enable', [
            'QR_Image' => $QR_Image,
            'secret' => session('google2fa_secret'),
            'reauthenticating' => true
        ]);
    }

    public function enable2FA(Request $request)
    {
        $user = Auth::user();
        $google2fa = app('pragmarx.google2fa');

        $secret = $request->input('verify-code');
        $valid = $google2fa->verifyKey(session('google2fa_secret'), $secret);

        if($valid){
            $user->google2fa_secret = session('google2fa_secret');
            $user->disabled_2fa = false;
            $user->save();
            return redirect()->route('home');
        }else{
            $user = Auth::user();
            $user->google2fa_secret = NULL;
            $user->save();

            return back()->with('error',"Código de verificação inválido.");
        }
    }
    */

    public function openSupport(Client $client)
    {
        $response = $client->request('GET', env('SUPORTE_URL').'/api/user', [
            'query' => [
                'api_token' => auth()->user()->api_token,
            ]
        ]);

        $response = (string) $response->getBody();
        $response = json_decode($response);

        return response()->json(array('redirect' => env('SUPORTE_URL') . '/authenticate/'.$response->id.'/'.substr(sha1($response->id), -4)));
    }
}
