<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use App\Http\Controllers\BaseController;

use App\Wallet;

use Auth;



class WalletController extends BaseController

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index($is_update = false)
    {

        if($this->checkAdmin()) {

            return redirect()->route('admin.index');

        }

        $checkWallet = Wallet::where('user_id', Auth::id())->first();

        if (!empty($checkWallet) && $checkWallet->address != '') { 

            return redirect()->route('home');

        }



        return view('wallets.index', ['is_update' => $is_update]);

    }



    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        //

    }



    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)
    {

        if(!$this->checkAddress($request->address)){

            return back()->withError('Invalid USDTBEP2 Address');

        }



        Wallet::create([

            'user_id' => Auth::id(),

            'address' => $request->address,

        ]);



        return redirect()->route('home');

    }



    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function show($id)

    {

        //

    }



    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        //

    }



    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function update(Request $request, $id = 0)
    {

        if(!$this->checkAddress($request->address)){

            return back()->withError('Invalid USDTBEP2 Address');

        }

        if(empty($request->address)) {

            return back()->withError('an error occurred, please try again later');

        }

        $wallet = Wallet::where('user_id', Auth::id())
                          ->update(['address' => $request->address]);

        return back()->withWalletStatus('Wallet updated');

    }



    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        //

    }



    function checkAddress($address)

    {

        if (!preg_match("#^bnb(.*)$#i", $address)) {

            return false;

        }

        if(strlen($address) != 42) {
            return false;
        }

        return true;

        /*
        $charsetHex = '0123456789ABCDEF';

        $charsetB58 = '123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz';

        $raw = "0";

        for ($i = 0; $i < strlen($address); $i++) {

            $current = (string) strpos($charsetB58, $address[$i]);

            $raw = (string) bcmul($raw, "58", 0);

            $raw = (string) bcadd($raw, $current, 0);

        }

        $hex = "";

        while (bccomp($raw, 0) == 1) {

            $dv = (string) bcdiv($raw, "16", 0);

            $rem = (integer) bcmod($raw, "16");

            $raw = $dv;

            $hex = $hex . $charsetHex[$rem];

        }

        $withPadding = strrev($hex);

        for ($i = 0; $i < strlen($address) && $address[$i] == "1"; $i++) {

            $withPadding = "00" . $withPadding;

        }

        if (strlen($withPadding) % 2 != 0) {

            $withPadding = "0" . $withPadding;

        }



        $decoded = $withPadding;



        if (strlen($decoded) != 50) {

            return false;

        }

        $version = substr($decoded, 0, 2);

        $check = substr($decoded, 0, strlen($decoded) - 8);

        $check = pack("H*", $check);

        $check = hash("sha256", $check, true);

        $check = hash("sha256", $check);

        $check = strtoupper($check);

        $check = substr($check, 0, 8);

        return ($check == substr($decoded, strlen($decoded) - 8));
        */
    

    }



}

