<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PragmaRX\Google2FAQRCode\Google2FA;

use app\User;

class TwoFactorController extends Controller
{
    public function enable2Fa(Request $request){
        if($request->ajax()){
            $user = auth()->user();
            $google2fa = new Google2FA();
            $secretKey = $google2fa->generateSecretKey();
            $qrCode = $google2fa->getQRCodeInline(
                config('app.name'),
                $user->email,
                $secretKey
            );

            return response()->json(['status'=>true,'message'=>'OK','data'=>['qr'=>$qrCode,'secretKey'=>$secretKey]]);
        }
    }

    public function disabled2Fa(Request $request){
        if($request->ajax()){
            $user = auth()->user();

            $google2fa = new Google2FA();
            $otp_secret = $user->google2fa_secret;

            if (!$google2fa->verifyKey($otp_secret, $request->one_time_password)) {
                return response()->json(['status'=>false,'message'=>'A senha de uso único é inválida']);
            }

            $user->google2fa_secret = NULL;
            $user->save();

            return response()->json(['status'=>true,'message'=>'Autenticação de 2 fatores desabilitada com sucesso']);
        }
    }

    public function verify2Fa(Request $request){
        if($request->ajax()){
            $authId = auth()->id();
            $user = User::find($authId);
            $user->google2fa_secret = $request->secretKey; 
            $user->save();
            return response()->json(['status'=>true,'message'=>'Autenticação de 2 fatores adicionada com sucesso']);
            
        }
    }

}
