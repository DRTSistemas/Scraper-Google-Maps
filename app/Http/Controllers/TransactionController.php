<?php

namespace App\Http\Controllers;

use App\Services\BscScanService;

use Illuminate\Http\Request;
use App\Transaction;
use Carbon\Carbon;

class TransactionController extends Controller

{


    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function update(Request $request)
    {

        try {
            $bscService = new BscScanService();

            //check if hash exists and receiver address and value
            $donation = Transaction::where('id', $request->transaction_id)->first();

            $hash = $this->clean($request->hash);

            //check hash
            $checkHash = Transaction::where([['hash', $hash]])->first();

            if(!empty($checkHash)) {
                return redirect()->back()->with('error_code', $request->transaction_id)->withError('Transaction already exists');
            }

            $transaction = $bscService->parseTransaction($hash);

            /*
            $blockchain = new Blockchain;

            $transaction = $blockchain->Explorer->getTransaction($hash);

            if (!$transaction) {

                return redirect()->back()->with('error_code', $request->transaction_id)->withError('Trasaction Hash doesnt exists');

            }
            */

            if(isset($transaction['error'])) {
                return redirect()->back()->with('error_code', $request->transaction_id)->withError('Trasaction Hash doesnt exists');

            }

            //save the hash on transactions
            $donation->who_requested = auth()->user()->id;
            $donation->hash = $hash;
            $donation->save();

            /*
            $outputs = $transaction->outputs;

            foreach ($outputs as $key => $value) {


                if ($donation->user()->wallet()->address == $value->address) {

                    if (($donation->value) == $value->value) {

                        if($value->coin !== 'USDT-6D8') {
                            return redirect()->back()->with('error_code', $request->transaction_id)->withError(__('The asset for this transaction is wrong. Only USDT submissions are allowed'));
                        }

                        //save the hash on transactions
                        $donation->who_requested = auth()->user()->id;
                        $donation->hash = $hash;
                        $donation->save();

                        return redirect()->back();

                    } else {

                        return redirect()->back()->with('error_code', $request->transaction_id)->withError(__('The value of the transaction is wrong'));

                    }

                }

            }
            */

            if ($donation->user()->wallet()->address == $transaction[0]['to']) {
                if (($donation->value) == $transaction[0]['value']) {

                    //save the hash on transactions
                    $donation->who_requested = auth()->user()->id;
                    $donation->hash = $hash;
                    $donation->save();

                    return redirect()->back();

                } else {
                    return redirect()->back()->with('error_code', $request->transaction_id)->withError(__('The value of the transaction is wrong'));
                }
            }
            
            return back()->with('error')->with('error_code', $request->transaction_id)->withError(__('Transaction not found'));

        } catch (\Exception $e) {
           return redirect()->back()->with('error_code', $request->transaction_id)->withError(__('Transaction does not exists'));

        }

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

    public function clean($string) {
       $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
       $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

       return preg_replace('/-+/', '', $string); // Replaces multiple hyphens with single one.
    }



}

