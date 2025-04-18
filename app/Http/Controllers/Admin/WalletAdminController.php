<?php



namespace App\Http\Controllers\Admin;



use App\Http\Controllers\BaseController;

use Illuminate\Http\Request;



use Auth;

use App\Wallet;



class WalletAdminController extends BaseController

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        if(!$this->checkAdmin()){

            return redirect()->route('login');

        }



        return view('admin.wallets.index', ['wallets' => Wallet::where('user_id', Auth::id())->paginate(15)]);

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

        if(!$this->checkAdmin()){

            return redirect()->route('login');

        }



        if(!$this->checkAddress($request->address)){

            return back()->withError('Invalid Bitcoin Address');

        }



        Wallet::create([

            'user_id' => Auth::id(),

            'address' => $request->address,

        ]);



        return back()->withStatus('Address added successfully');

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

    public function update(Request $request, $id)

    {

        //

    }



    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        if(!$this->checkAdmin()){

            return redirect()->route('login');

        }



        $wallet = Wallet::find($id);



        $wallet->delete();



        return back()->withStatus('Wallet deleted');

    }



    function checkAddress($address)

    {

        if (preg_match('/[^1-9A-HJ-NP-Za-km-z]/', $address)) {

            return false;

        }



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

    

    }

}

