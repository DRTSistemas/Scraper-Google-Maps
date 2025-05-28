<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use Carbon\Carbon;

use Auth;
use App\Plan;
use App\UserPlan;
use App\Wallet;
use App\User;
use App\Transaction;
use App\Donation;
use App\Bonus;
use App\Request as ModelRequest;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HomeController extends BaseController
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {

        if($this->checkAdmin()) {
            return redirect()->route('admin.index');
        }

        $config = $this->config();

        // Obtém o usuário logado
        $user = Auth::user();

        // Requests do usuário nas últimas 24 horas
        $last24HoursRequests = ModelRequest::where('user_id', $user->id)
                            ->whereDate('created_at', '>=', Carbon::now()->subDays(1))
                            ->orderBy('created_at', 'desc')
                            ->count();

        // Requests do usuário nos últimos 30 dias
        $last30DaysRequests = ModelRequest::where('user_id', $user->id)
                            ->whereDate('created_at', '>=', Carbon::now()->subDays(30))
                            ->orderBy('created_at', 'desc')
                            ->count();

        return view('dashboard', [
            'countLastDayRequests' => $last24HoursRequests,
            'countLastMonthRequests' => $last30DaysRequests,
            'requestsLeft' => $user->totalRequestsLeft(),
            'plans' => Plan::where('active', 1)->orderBy('plan_value', 'asc')->paginate(15),
            'config' => $config,
            'now' => Carbon::now()
        ]);
    }

    public function search()
    {

        if($this->checkAdmin()) {
            return redirect()->route('admin.index');
        }

        $config = $this->config();

        // Obtém o usuário logado
        $user = Auth::user();

        // Requests do usuário nas últimas 24 horas
        $last24HoursRequests = ModelRequest::where('user_id', $user->id)
                            ->whereDate('created_at', '>=', Carbon::now()->subDays(1))
                            ->orderBy('created_at', 'desc')
                            ->count();

        // Requests do usuário nos últimos 30 dias
        $last30DaysRequests = ModelRequest::where('user_id', $user->id)
                            ->whereDate('created_at', '>=', Carbon::now()->subDays(30))
                            ->orderBy('created_at', 'desc')
                            ->count();
        
        return view('search', [
            'countLastDayRequests' => $last24HoursRequests,
            'countLastMonthRequests' => $last30DaysRequests,
            'requestsLeft' => $user->totalRequestsLeft(),
            'config' => $config,
            'now' => Carbon::now()
        ]);
    }

    public function searchRequest(Request $request)
    {

        /*
        if($this->checkAdmin()) {
            return false;
        }
        */

        if(!Auth::user()->hasActivePlan()) {
            return false;
        }

        $config = $this->config();

        // Obtém as chaves do banco de dados e converte em array
        $apiKeys = explode("\r\n", $config['api_key_serper']);
        $apiKeys = array_map('trim', $apiKeys);
        $apiIndex = 0; // índice atual da chave

        $onlyMobile = filter_var($request->input('onlyMobile'), FILTER_VALIDATE_BOOLEAN);

        $curl = curl_init();
        $allResponses = []; // Array para armazenar todas as respostas

        for ($page = 1; $page <= 20; $page++) {
            $apiKey = $apiKeys[$apiIndex] ?? null;

            // Verifica o saldo da chave
            curl_setopt_array($curl, [
                CURLOPT_URL => 'https://google.serper.dev/account',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => [
                    'X-API-KEY: ' . $apiKey
                ],
            ]);

            $checkResponse = curl_exec($curl);
            $checkData = json_decode($checkResponse, true);

            //dd($apiIndex, $apiKey);

            if (
                (!isset($checkData['balance'])) || // balance não está definido
                (isset($checkData['balance']) && $checkData['balance'] <= 0) || // balance negativo
                (isset($checkData['statusCode']) && $checkData['statusCode'] == 403) // erro de autorização
            ) {
                // Remove do array atual
                unset($apiKeys[$apiIndex]);
                $apiKeys = array_values($apiKeys); // reindexar

                // Atualiza no banco de dados
                DB::table('configs')
                ->where('name', 'api_key_serper')
                ->update([
                    'value' => implode("\r\n", $apiKeys)
                ]);

                // Reinicia
                $apiIndex = 0;
                $page--; // refazer a página com nova chave
                continue;
            }

            //dd($checkData);

            $params = [
                //'q' => $request->input('search') . ' ' . $request->input('city') . ', ' . $request->input('state') . ', ' . $request->input('neighborhood') . ', ' . $request->input('country'),
                'q' => $request->input('search') . ' ' . $request->input('neighborhood') . ', ' . $request->input('city') . ', ' . $request->input('state') . ', ' . $request->input('country'),
                'gl' => 'br',
                'hl' => 'pt-br',
                'page' => $page
            ];

            curl_setopt_array($curl, [
                CURLOPT_URL => 'https://google.serper.dev/places',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($params), // Enviando como JSON
                CURLOPT_HTTPHEADER => [
                    'X-API-KEY: ' . $apiKey,
                    'Content-Type: application/json'
                ],
            ]);

            $response = curl_exec($curl);
            if ($response === false) {
                echo "Erro no cURL: " . curl_error($curl);
                break;
            }

            $decodedResponse = json_decode($response, true);
            
            if (!empty($decodedResponse)) {
                $allResponses[] = $decodedResponse['places'];
            }
        }

        curl_close($curl);

        $places = array_merge(...$allResponses);

        if($onlyMobile) {
            $places = array_filter($places, function($p) {
                return isset($p['phoneNumber']) && preg_match("/^(\+55 \d{2} 9\d{4}-\d{4}|\(\d{2}\) 9\d{4}-\d{4})$/", $p['phoneNumber']);
            });
        }

        //dd($places, $params);

        auth()->user()->updateOldestPlanRequests(-1);

        //dd($places, $onlyMobile);
        
        return response()->json([
            'success' => true,
            'places'  => $places,
            'credits' => 1,
            'now' => Carbon::now()
        ]);
    }

    /*
    public function getDonation($id) {
        $config = $this->config();

        $checkPlan = UserPlan::where('id', $id)->first();
        $value = $checkPlan->plan()->plan_value * ($config['max_donate'] / 100);

        $ifExistsTrans = Transaction::where([
            ['user_plan_id', $checkPlan->id],
            ['status', 0]
        ])->sum('value');

        if($ifExistsTrans < $value) {
            //get all donation where not user id = auth:id() and status = 0 or 2 and created_at >= 4 days
            $findDonation = Donation::where([
                ['status', '=', 0],
                ['user_id', '<>', Auth::id()],
                ['created_at', '<', Carbon::now()->subDays($config['min_payment_days'])],
            ])->orWhere([
                ['status', '=', 2],
                ['user_id', '<>', Auth::id()],
                ['rest', '<>', null],
                ['created_at', '<', Carbon::now()->subDays($config['min_payment_days'])],
            ])->orderBy('created_at', 'ASC')->orderBy('total', 'ASC')->get();

            //dd($findDonation->count());

            foreach ($findDonation as $fd) {
                $usersByWallet = Wallet::select('user_id')
                ->where([
                    ['address', $fd->wallet()->address]
                ])->get();

                $checkDonationsOpen = UserPlan::where([
                    ['status', 1],
                    ['movimentation', 0],
                ])->where(function ($query) use ($usersByWallet) {
                    $query->whereIn('user_id', $usersByWallet);
                })->get();

                $checkDonationsReceived =  Donation::where([
                    ['user_id', $fd->user_id],
                    ['id', '<>', $fd->id],
                ])->where(function ($query) use ($usersByWallet) {
                    $query->whereIn('status', [1, 2]);
                })->get();

                if($fd->wallet()->address != '' && $checkDonationsOpen->isEmpty() && $checkDonationsReceived->isEmpty()) {
                    $findDonation = $fd;
                    break;
                }
            }

            $lastDonationReceive = Donation::where([
                ['user_plan_id', $checkPlan->id],
                ['status', 3],
                ['bonus', 0],
            ])->orderBy('updated_at', 'desc')->first();

            $transactionsCreated = Transaction::where([
                ['user_plan_id', $checkPlan->id],
                ['status', '<>', 2],
                ['created_at', '>', $lastDonationReceive->updated_at]
            ])->orderBy('id', 'desc')->sum('value');

            $value = $value - $transactionsCreated;

            if($value > 0) {
                if($findDonation->count() == 0){
                    $red_account = User::where('level', 1)->get()->random(1);

                    $maxAvailableDonate = Plan::select('plan_value')->where('active', 1)->orderBy('plan_value', 'DESC')->first()->plan_value * ($config['max_receive'] / 100);
                    $totalDoar = $value;
                    $setValue = 0;
                    $statusDonate = 1;

                    if($totalDoar > $maxAvailableDonate) {
                        $statusDonate = 2;
                    }

                    //create a donation to adm
                    $adm_donation = Donation::create([
                        'total' => $value,
                        'user_id' => $red_account[0]->id,
                        'status' => $statusDonate,
                    ]);

                    if($totalDoar > $maxAvailableDonate) {

                        $adminsUsed = [];

                        while ($totalDoar > 0) {
                            $red_account = User::where('level', 1)->get()->random(1);

                            if(!in_array($red_account[0]->id, $adminsUsed)) {
                                array_push($adminsUsed, $red_account[0]->id);

                                if(abs($totalDoar) < $maxAvailableDonate) {
                                    $setValue = abs($totalDoar);
                                } else {
                                    $setValue = $maxAvailableDonate;
                                }

                                $totalDoar -= $maxAvailableDonate;

                                Transaction::create([
                                    'donation_id' => $adm_donation->id,
                                    'user_plan_id' => $checkPlan->id,
                                    'to_user_id' =>  $red_account[0]->id,
                                    'to_wallet_id' => $red_account[0]->wallet()->id,
                                    'value' => $setValue,
                                ]);
                            }

                        }

                    } else {
                        Transaction::create([
                            'donation_id' => $adm_donation->id,
                            'user_plan_id' => $checkPlan->id,
                            'to_user_id' =>  $red_account[0]->id,
                            'to_wallet_id' => $red_account[0]->wallet()->id,
                            'value' => $totalDoar,
                        ]);
                    }
                } else {
                    //Create the transaction and calculate the rest of the donation
                    $createTransactions = $this->findDonations($checkPlan, $value);

                }

                $checkPlan->movimentation = 2;
                $checkPlan->save();
                mail('felipe.fpc1@outlook.com', 'GetDonations: '.$checkPlan->id, $checkPlan->movimentation .' - '.$checkPlan->transactions_left);
            }

            return redirect()->route('home');
        }

        return redirect()->route('home');
    }

    protected function findDonations($checkPlan, $valueDonate) {
        try {
            $config = $this->config();

            $findDonation = Donation::where([
                ['status', '=', 0],
                ['user_id', '<>', Auth::id()],
                ['created_at', '<', Carbon::now()->subDays($config['min_payment_days'])],
            ])
            ->orWhere([
                ['status', '=', 2],
                ['user_id', '<>', Auth::id()],
                ['rest', '<>', null],
                ['created_at', '<', Carbon::now()->subDays($config['min_payment_days'])],
            ])
            ->orderBy('created_at', 'ASC')
            ->orderBy('total', 'ASC')
            ->get();

            if($findDonation->isEmpty()) {
                return false;
            }

            $numberTransactions = 0;
            $totalToDonate = $valueDonate;

            foreach ($findDonation as $key => $value) {

                $usersByWallet = Wallet::select('user_id')
                ->where([
                    ['address', $value->wallet()->address]
                ])->get();

                $checkDonationsOpen = UserPlan::where([
                    ['status', 1],
                    ['movimentation', 0],
                ])->where(function ($query) use ($usersByWallet) {
                    $query->whereIn('user_id', $usersByWallet);
                })->get();

                $checkDonationsReceived =  Donation::where([
                    ['user_id', $value->user_id],
                    ['id', '<>', $value->id],
                ])->where(function ($query) use ($usersByWallet) {
                    $query->whereIn('status', [1, 2]);
                })->get();

                if($value->wallet()->address != '' && $checkDonationsOpen->isEmpty() && $checkDonationsReceived->isEmpty()) {

                    if ($totalToDonate > 0) {
                        $numberTransactions += 1;

                        if ($value->status == 0) {
                            if ($totalToDonate - $value->total == 0) {
                                $check = $this->checkTransaction($value, $totalToDonate);

                                if($check[0]) {
                                    $transaction = Transaction::create([
                                        'value' => $check[1],
                                        'donation_id' => $value->id,
                                        'user_plan_id' => $checkPlan->id,
                                        'to_user_id' => $value->user_id,
                                        'to_wallet_id' => $value->user()->wallet()->id
                                    ]);

                                    $value->status = 1;
                                    $value->save();

                                    $totalToDonate = $totalToDonate - $check[1];

                                    if($totalToDonate == 0) {
                                        break;
                                    }

                                } else {
                                    $numberTransactions -= 1;
                                }
                            } else if($totalToDonate - $value->total > 0) {
                                $check = $this->checkTransaction($value, $value->total);

                                if($check[0]) {
                                    $transaction = Transaction::create([
                                        'value' => $check[1],
                                        'donation_id' => $value->id,
                                        'user_plan_id' => $checkPlan->id,
                                        'to_user_id' => $value->user_id,
                                        'to_wallet_id' => $value->user()->wallet()->id
                                    ]);

                                    $value->status = 1;
                                    $value->save();

                                    $totalToDonate -= $check[1];
                                } else {
                                    $numberTransactions -= 1;
                                }
                            } else {
                                $check = $this->checkTransaction($value, $totalToDonate);

                                if($check[0]) {
                                    $transaction = Transaction::create([
                                        'value' => $check[1],
                                        'donation_id' => $value->id,
                                        'user_plan_id' => $checkPlan->id,
                                        'to_user_id' => $value->user_id,
                                        'to_wallet_id' => $value->user()->wallet()->id
                                    ]);

                                    $rest = $value->total - $check[1];
                                    $value->rest = ($rest > 0) ? $rest : null;
                                    $value->status = 2;

                                    $value->save();

                                    $totalToDonate = $totalToDonate - $check[1];

                                    if($totalToDonate == 0) {
                                        break;
                                    }
                                } else {
                                    $numberTransactions -= 1;
                                }
                            }

                        } elseif ($value->status == 2) {
                            if ($totalToDonate - $value->rest == 0) {
                                $check = $this->checkTransaction($value, $totalToDonate);

                                if($check[0]) {
                                    $transaction = Transaction::create([
                                        'value' => $check[1],
                                        'donation_id' => $value->id,
                                        'user_plan_id' => $checkPlan->id,
                                        'to_user_id' => $value->user_id,
                                        'to_wallet_id' => $value->user()->wallet()->id
                                    ]);

                                    $value->rest = null;
                                    $value->save();

                                    $totalToDonate = $totalToDonate - $check[1];

                                    if($totalToDonate == 0) {
                                        break;
                                    }
                                } else {
                                    $numberTransactions -= 1;
                                }
                            } elseif($totalToDonate - $value->rest > 0) {
                                $check = $this->checkTransaction($value, $value->rest);

                                if($check[0]) {
                                    $transaction = Transaction::create([
                                        'value' => $check[1],
                                        'donation_id' => $value->id,
                                        'user_plan_id' => $checkPlan->id,
                                        'to_user_id' => $value->user_id,
                                        'to_wallet_id' => $value->user()->wallet()->id
                                    ]);

                                    $totalToDonate -= $check[1];

                                    if($check[1] == $value->rest) {
                                        $value->rest = null;
                                        $value->save();
                                    } else {
                                        $value->rest -= $check[1];
                                        $value->save();
                                    }
                                } else {
                                    $numberTransactions -= 1;
                                }
                            } else {
                                $check = $this->checkTransaction($value, $totalToDonate);

                                if($check[0]) {
                                    $transaction = Transaction::create([
                                        'value' => $check[1],
                                        'donation_id' => $value->id,
                                        'user_plan_id' => $checkPlan->id,
                                        'to_user_id' => $value->user_id,
                                        'to_wallet_id' => $value->user()->wallet()->id
                                    ]);

                                    $rest = $value->rest - $totalToDonate;
                                    $value->rest = ($rest > 0) ? $rest : null;
                                    $value->status = 2;

                                    $value->save();

                                    $totalToDonate = $totalToDonate - $check[1];

                                    if($totalToDonate == 0) {
                                        break;
                                    }
                                } else {
                                    $numberTransactions -= 1;
                                }
                            }
                        }
                    }
                }
            }

            if ($totalToDonate > 0) {
                $maxAvailableDonate = Plan::select('plan_value')->where('active', 1)->orderBy('plan_value', 'DESC')->first()->plan_value * ($config['max_receive'] / 100);
                $totalDoar = $totalToDonate;
                $setValue = 0;
                $statusDonate = 1;

                if($totalDoar > $maxAvailableDonate) {
                    $statusDonate = 2;
                }

                //create for admin
                $red_account = User::where('level', 1)->get()->random(1);

                $adm_donation = Donation::create([
                    'total' => $totalToDonate,
                    'user_id' => $red_account[0]->id,
                    'status' => $statusDonate,
                ]);

                if($totalDoar > $maxAvailableDonate) {

                    $adminsUsed = [];

                    while ($totalDoar > 0) {
                        $red_account = User::where('level', 1)->get()->random(1);

                        if(!in_array($red_account[0]->id, $adminsUsed)) {
                            array_push($adminsUsed, $red_account[0]->id);

                            if(abs($totalDoar) < $maxAvailableDonate) {
                                $setValue = abs($totalDoar);
                            } else {
                                $setValue = $maxAvailableDonate;
                            }

                            $totalDoar -= $maxAvailableDonate;

                            $transaction = Transaction::create([
                                'donation_id' => $adm_donation->id,
                                'user_plan_id' => $checkPlan->id,
                                'to_user_id' =>  $red_account[0]->id,
                                'to_wallet_id' => $red_account[0]->wallet()->id,
                                'value' => $setValue,
                            ]);

                            $numberTransactions += 1;
                        }

                    }

                } else {
                    $transaction = Transaction::create([
                        'donation_id' => $adm_donation->id,
                        'user_plan_id' => $checkPlan->id,
                        'to_user_id' =>  $red_account[0]->id,
                        'to_wallet_id' => $red_account[0]->wallet()->id,
                        'value' => $totalDoar,
                    ]);

                    $numberTransactions += 1;
                }
            }

            $checkPlan->movimentation = 2;
            $checkPlan->transactions_left = $numberTransactions;
            $checkPlan->save();
            mail('felipe.fpc1@outlook.com', 'FindDonations: '.$checkPlan->id, $checkPlan->movimentation .' - '.$checkPlan->transactions_left);
            //code...
        } catch (\Exception $e) {
            mail('felipe.fpc@outlook.com', 'Error', $e->getMessage());
            return redirect()->back()->withError('an error occurred, please try again');
        }

    }

     public function checkTransaction($donation, $totalToDonate) {
        $config = $this->config();

        $donationWhoReceive = $donation;

        if($totalToDonate <= 0) {
            return [false];
        }

        mail('felipe.fpc1@outlook.com', 'checkTransaction - Donation: '.$donation->id, 'TotalDonate: ' . $totalToDonate);

        if(!empty($donationWhoReceive->userPlan())) {
            $maxWhoReceive = ($config['max_receive'] / 100) * $donationWhoReceive->userPlan()->plan()->plan_value;

            $checkTransactionsCreated = Transaction::where([
                ['status', '<>', 2],
                ['donation_id', $donationWhoReceive->id]
            ])->sum('value');

            $valuePlanActive = $donationWhoReceive->userPlan()->plan()->plan_value;
            $justChecking = (($donationWhoReceive->userPlan()->profit() * 10 / 100) * $valuePlanActive);

            if (($justChecking + $donationWhoReceive->user()->earnings_bonus) < ($valuePlanActive * ($config['max_profit'] / 100) )) {

                if(($justChecking + $donationWhoReceive->user()->earnings_bonus) + $totalToDonate > ($valuePlanActive * ($config['max_profit'] / 100) )) {
                    $totalToDonate = ($valuePlanActive * ($config['max_profit'] / 100) ) - ($justChecking + $donationWhoReceive->user()->earnings_bonus);
                }
            }

            mail('felipe.fpc1@outlook.com', 'checkTransaction - Donation: '.$donation->id, 'TransactionCreated: ' . $checkTransactionsCreated . ' JustCheck: ' . $justChecking . ' TotalDonate: ' . $totalToDonate);

            if(($checkTransactionsCreated + $totalToDonate) <= $maxWhoReceive) {
                return [true, $totalToDonate];
            }

            return [false];
        }

        return [true, $totalToDonate];
    }
    */
}
