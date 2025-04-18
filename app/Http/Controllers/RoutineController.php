<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Blockchain\Blockchain;
use Carbon\Carbon;

use App\Http\Controllers\BaseController;
use App\Transaction;
use App\User;
use App\UserPlan;
use App\Donation;
use App\Bonus;
use App\BonusRequest;
use App\Plan;

class RoutineController extends BaseController
{
    // TODO implement routine on index()
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $config = $this->config();
        //check all transactions with status 0

        $openTransaction = Transaction::where('status', 0)->get();
        $blockchain = new Blockchain;
        $latestBlock = $blockchain->Explorer->getLatestBlock();

        //dd($latestBlock->height);

        foreach ($openTransaction as $key => $value) {
            $userPlan = $value->userPlan();
            echo $userPlan . '<br>';

            $checkDonation = Donation::where('id', $value->donation_id)->first();
            echo $checkDonation . '<br>';

            //mail('felipe.fpc@outlook.com', 'Donation: '.$value->donation_id, $value->donation_id);

            if(!empty($value->hash)) {
                echo 'Hash is not empty: ' . $value->hash . '<br>';
                $transaction = $blockchain->Explorer->getTransaction($value->hash);
                $add1Hour = Carbon::parse($value->updated_at)->addHour();

                if(!empty($transaction->block_height) || Carbon::now() > $add1Hour) {
                    echo 'block height is not empty <br>';
                    $confirmations = $latestBlock->height - $transaction->block_height;
                    echo $confirmations . '<br>';
                    //if 3 confirmations

                    if ($confirmations >= 3 || Carbon::now() > $add1Hour) {

                        $donationsPay = [1];

                        //$donationsPay = [2880, 3123, 3128];

                        if(in_array($checkDonation->id, $donationsPay)) {
                            $checkDonation->status = 3;
                            $checkDonation->save();

                            $value->status = 1;
                            $value->save();
                        } else {
                            $all_profit = 0;
                            $dst = $checkDonation->userPlan();

                            echo $checkDonation->id . ' donation status is : ' . $checkDonation->status . '<br>';
                            if ($checkDonation->status == 1) {
                                echo 'Donation is total changing to status 3<br>';
                                $checkDonation->status = 3;
                                $checkDonation->save();
                            } elseif($checkDonation->status == 2) {
                                echo 'Donation is partial calculate everething<br>';

                                if(empty($checkDonation->rest)) {
                                    //with all value was donated
                                    $checkDonatedValue = Transaction::where([
                                        ['donation_id', '=', $value->donation_id],
                                        ['status', '=', 1]
                                    ])->sum('value');
                                    echo $checkDonatedValue , '+' , $value->value , '==' , $checkDonation->total , '<br>';
                                    if($checkDonatedValue + $value->value == $checkDonation->total){
                                        $checkDonation->status = 3;
                                        $checkDonation->save();
                                    }

                                }
                            }

                            if(!empty($userPlan)){

                                $hasDonation = Donation::where([
                                    ['user_plan_id', $userPlan->id],
                                    ['status', 0],
                                    ['bonus', 0],
                                ])->orWhere([
                                    ['user_plan_id', $userPlan->id],
                                    ['status', 2],
                                    ['bonus', 0],
                                ])->count();

                                echo 'Has donation: ' . $hasDonation . '<br>';

                                if ($userPlan->status == 0) {

                                    if($userPlan->transactions_left > 0) {
                                        $userPlan->transactions_left -= 1;
                                        $userPlan->save();
                                    }

                                    if($userPlan->transactions_left == 0) {
                                        $transactionsMade = Transaction::where([
                                            ['user_plan_id', $userPlan->id],
                                            ['status', '<>', 2],
                                            ['hash', '<>', null]
                                        ])->sum('value');

                                        if($transactionsMade == $userPlan->plan()->plan_value) {
                                            echo 'userPlan status is 0 <br>';

                                            $userPlan->movimentation = 1;
                                            $userPlan->status = 1;
                                            $userPlan->save();

                                            //create bonus for father
                                            $this->bonus($value, $config);

                                            $max_receive = $userPlan->Plan()->plan_value * ($config['max_receive'] / 100);

                                            if($hasDonation == 0) {

                                                $checkNewPlans = UserPlan::where([
                                                    ['user_id', $userPlan->user()->id],
                                                    ['status', 1],
                                                    ['is_20', 1]
                                                ])->first();

                                                if($userPlan->is_20) {
                                                    Donation::create([
                                                        'user_plan_id' => $userPlan->id,
                                                        'user_id' => $userPlan->user_id,
                                                        'total' => $max_receive,
                                                    ]);
                                                } else {
                                                    if($checkNewPlans && $userPlan->plan()->plan_value <= $checkNewPlans->plan()->plan_value) {
                                                        $returnWait = Donation::create([
                                                            'user_plan_id' => $userPlan->id,
                                                            'user_id' => $userPlan->user_id,
                                                            'total' => $max_receive,
                                                        ]);

                                                        Donation::where('id', $returnWait->id)->update([
                                                            'is_20' => 0
                                                        ]);
                                                    } else {
                                                        $returnWait = Donation::create([
                                                            'user_plan_id' => $userPlan->id,
                                                            'user_id' => $userPlan->user_id,
                                                            'total' => $max_receive,
                                                        ]);

                                                        Donation::where('id', $returnWait->id)->update([
                                                        'status' => 81,
                                                        'created_at' => '2030-01-01 00:00:00',
                                                        'updated_at' => '2030-01-01 00:00:00',
                                                        'is_20' => 0
                                                    ]);
                                                    }
                                                }

                                                $userPlan->movimentation = 1;
                                                $userPlan->save();
                                            }
                                        }
                                    }

                                } elseif ($userPlan->status == 1) {

                                    if($userPlan->transactions_left > 0) {
                                        $userPlan->transactions_left -= 1;
                                        $userPlan->save();
                                    }

                                    if($userPlan->transactions_left == 0) {
                                        $max_receive = $userPlan->Plan()->plan_value * ($config['max_receive'] / 100);

                                        if($hasDonation == 0) {

                                            $checkNewPlans = UserPlan::where([
                                                ['user_id', $userPlan->user()->id],
                                                ['status', 1],
                                                ['is_20', 1]
                                            ])->first();

                                            if($userPlan->is_20) {
                                                Donation::create([
                                                    'user_plan_id' => $userPlan->id,
                                                    'user_id' => $userPlan->user_id,
                                                    'total' => $max_receive,
                                                ]);
                                            } else {
                                                if($checkNewPlans && $userPlan->plan()->plan_value <= $checkNewPlans->plan()->plan_value) {
                                                    $returnWait = Donation::create([
                                                        'user_plan_id' => $userPlan->id,
                                                        'user_id' => $userPlan->user_id,
                                                        'total' => $max_receive,
                                                    ]);

                                                    Donation::where('id', $returnWait->id)->update([
                                                        'is_20' => 0
                                                    ]);
                                                } else {
                                                    $returnWait = Donation::create([
                                                        'user_plan_id' => $userPlan->id,
                                                        'user_id' => $userPlan->user_id,
                                                        'total' => $max_receive,
                                                    ]);

                                                    Donation::where('id', $returnWait->id)->update([
                                                        'status' => 81,
                                                        'created_at' => '2030-01-01 00:00:00',
                                                        'updated_at' => '2030-01-01 00:00:00',
                                                        'is_20' => 0
                                                    ]);
                                                }
                                            }

                                            $userPlan->movimentation = 1;
                                            $userPlan->save();
                                        }
                                    }
                                }

                            } else {
                                $red_account = User::where('level', 1)->get()->random(1);

                                $value->user_plan_id = $red_account[0]->planAdmin()->id;
                                $value->save();
                            }

                            // change transaction status to 1
                            $value->status = 1;
                            $value->save();

                            if($checkDonation->bonus == 1 && $checkDonation->status == 3){
                                //change bonus request to 1
                                $donationsPay = [54045, 54046, 54047];
                                if(!in_array($checkDonation->id, $donationsPay)) {
                                    $b_request = BonusRequest::where('donation_id', $checkDonation->id)->first();
                                    $b_request->status = 1;
                                    $b_request->save();

                                    $all_bonus = Bonus::where([
                                        ['user_id', $checkDonation->user_id]
                                    ])->get();

                                    foreach ($all_bonus as $keya => $valuea) {
                                        if($b_request->created_at->format('Y-m-d H:i') == $valuea->updated_at->format('Y-m-d H:i')) {
                                            $valuea->timestamps = false;
                                            $valuea->status = 2;
                                            $valuea->save();
                                            $valuea->timestamps = true;
                                        }
                                    }
                                }

                            }

                            echo $dst . '<br>';
                            if(!empty($dst) && $checkDonation->status == 3){
                                $valuePlanActive = $dst->plan()->plan_value;
                                $justChecking = ((( ($config['max_receive'] - $config['max_donate']) / 100) * $valuePlanActive) * $dst->profit() + ($dst->user()->earnings_bonus)) / ($valuePlanActive * 2) * 100 * 2;
                                $maxProfit = ($config['max_profit'] - $config['max_donate']) / ($config['max_receive'] - $config['max_donate']);

                                // profit >= echo (200 - 30) / (40 - 30) || justChecking + bonus >= max_profit
                                // também em:
                                // bonus()
                                // home - checkTransaction

                                // breacubm dashboard is_20 table plans
                                // testar bonus() +1 plan

                                // BAR
                                //((( (40 - 30) / 100) * 40) * 1 + (0)) / (40 * 2) * 100;
                                // COUNTER
                                //((( (40 - 30) / 100) * 40) * 1 + (0)) / (40 * 2) * 100 * 2;

                                if ($dst->profit() >= $maxProfit || $justChecking >= $config['max_profit']) {
                                    $dst->status = 3;

                                    User::where('id', $dst->user()->id)
                                        ->update(['earnings_bonus' => 0]);
                                } else {
                                    mail('felipe.fpc1@outlook.com', 'DST: '.$dst->id, $dst->transactions_left);
                                    $dst->movimentation = 0;
                                }

                                $dst->save();
                            }
                            echo $dst . '<Br>';

                        }

                    }
                }
            } else {
                echo 'Hash is empty, check for expiraton time ' . $config['max_time_to_donate']. ' min <br>';
                $now = Carbon::now();
                $diff = $now->diffInMinutes($value->created_at);
                if ($diff >= $config['max_time_to_donate'] && !empty($userPlan)) {

                    //check if is the fist donation
                    if($userPlan->status == 0){
                        $checkDonateAnyValue = Transaction::where([
                            ['user_plan_id', $userPlan->id],
                            ['status', 1]
                        ])->orWhere([
                            ['user_plan_id', $userPlan->id],
                            ['status', 0],
                            ['hash', '<>', null]
                        ])->get();

                        if($checkDonateAnyValue->isEmpty()) {
                            echo 'Max time exceded, and is the first donation canceling plan <br>';
                            $userPlan->status = 2;
                            $userPlan->save();
                        } else {
                            $userPlan->movimentation = 0;
                            $userPlan->save();
                        }

                    } else {
                        echo 'Max time exceded, and is not the first donation keep plan <br>';
                        $userPlan->movimentation = 0;
                        $userPlan->save();
                    }

                    echo 'Max time exceded, cancel transaction <br>';
                    $value->status = 2;
                    $value->save();

                    if (!empty($checkDonation->user_plan_id)) {
                        /*
                        $checkDonation->status = 4;
                        $checkDonation->save();
                        */

                        if($checkDonation->status == 2) {
                            echo 'Donation is partial, returning value to the rest <br>';
                            if ($value->value + $checkDonation->rest == $checkDonation->total) {
                                $checkDonation->rest = null;
                                $checkDonation->status = 0;
                                $checkDonation->save();
                            } elseif($value->value + $checkDonation->rest < $checkDonation->total) {
                                //dd($value->value + $checkDonation->rest, $value->value, $checkDonation->rest, $checkDonation->total);

                                $checkDonation->rest += $value->value;
                                $checkDonation->save();
                                //dd($save);
                            } else {
                                $checkDonation->rest -= $value->value;
                                $checkDonation->save();
                            }
                        } elseif($checkDonation->status == 1) {
                            echo 'Donation is total, returning value to amount <br>';
                            $checkDonation->status = 0;
                            $checkDonation->save();
                        }
                    }

                }
            }
            echo '========================================<br>';
        }

    }

    //Check expired to send Admin donate
    public function payment() {
        $config = $this->config();

        //check all donations
        $donations = Donation::where('status', 0)->orWhere('status', 2)->get();

        $maxAvailableDonate = Plan::select('plan_value')->where('active', 1)->orderBy('plan_value', 'DESC')->first()->plan_value * ($config['max_receive'] / 100);

        foreach ($donations as $key => $value) {
            $now = Carbon::now();
            $diff = $now->diffInDays($value->created_at);

            if ($diff >= $config['max_payment_days']) {
                if ($value->status == 0) {
                    $totalDoar = $value->total;
                    $setValue = 0;

                    if($totalDoar > $maxAvailableDonate) {

                        while ($totalDoar > 0) {
                            if(abs($totalDoar) < $maxAvailableDonate) {
                                $setValue = abs($totalDoar);
                            } else {
                                $setValue = $maxAvailableDonate;
                            }

                            $totalDoar -= $maxAvailableDonate;

                            //create transaction to admin payment with total
                            $createTransaction = Transaction::create([
                                'value' => $setValue,
                                'donation_id' => $value->id,
                                'to_user_id' => $value->user()->id,
                                'to_wallet_id' => $value->user()->wallet()->id,
                            ]);
                        }

                    } else {
                        //create transaction to admin payment with total
                        $createTransaction = Transaction::create([
                            'value' => $totalDoar,
                            'donation_id' => $value->id,
                            'to_user_id' => $value->user()->id,
                            'to_wallet_id' => $value->user()->wallet()->id,
                        ]);
                    }

                    if ($createTransaction) {
                        $value->status = 1;
                        $value->save();
                    }
                }

                if ($value->status == 2 && $value->rest > 0) {
                    $totalDoar = $value->rest;
                    $setValue = 0;

                    if($totalDoar > $maxAvailableDonate) {

                        while ($totalDoar > 0) {

                            if(abs($totalDoar) < $maxAvailableDonate) {
                                $setValue = abs($totalDoar);
                            } else {
                                $setValue = $maxAvailableDonate;
                            }

                            $totalDoar -= $maxAvailableDonate;

                            $createTransaction = Transaction::create([
                                'value' => $setValue,
                                'donation_id' => $value->id,
                                'to_user_id' => $value->user()->id,
                                'to_wallet_id' => $value->user()->wallet()->id,
                            ]);
                        }

                    } else {
                        $createTransaction = Transaction::create([
                            'value' => $totalDoar,
                            'donation_id' => $value->id,
                            'to_user_id' => $value->user()->id,
                            'to_wallet_id' => $value->user()->wallet()->id,
                        ]);
                    }

                    if ($createTransaction) {
                        $value->rest = null;
                        $value->save();
                    }
                }
            }
        }
    }

    public function bonus($data, $config)
    {
        echo 'generating bonus <br>';

        $donating = $data->userPlan()->user();

        $father = $donating->indication();

        /*
        $checkChecks = UserPlan::where([['user_id', $data->userPlan()->user_id], ['status', 1]])->count();
        if ($checkChecks == 1) {
            $father->master += 1;
            $father->save();
        }
        */

        $fatherActivePlan = UserPlan::where([
            ['user_id', $father->id],
            ['status', 1],
            ['is_20', 1]
        ])->count();

        if ($father->level != 1) {
            /*
            if ($father->master >= $config['indications_to_master']) {
                echo 'father is master, generate all for him<br>';
                if ($fatherActivePlan > 0) {
                    $total_bonus = $config['common_bonus'] + $config['master_bonus'];

                    $total = $data->userPlan()->plan()->plan_value * ($total_bonus / 100);
                    Bonus::create([
                        'user_id' => $father->id,
                        'transaction_id' => $data->id,
                        'value' => $total,
                    ]);

                    $reponse = true;
                } else {
                    echo 'save on missing bonus table as user master';
                }

            } else {


            }
            */

            echo 'father is not master <br>';

            /*
            while ($check->master < $config['indications_to_master']) {
                $check = $check->indication();
                if($check->master >= $config['indications_to_master']) {
                    break;
                }
                if ($check->id == 1) {
                    break;
                }
            }
            */

            //Level 2
            $check = $father->indication();
            echo $check . '<br>';

            $masterActivePlan = UserPlan::where([
                ['user_id', $check->id],
                ['status', 1],
                ['is_20', 1]
            ])->count();

            if($check->level != 1) {
                if($masterActivePlan > 0) {
                    $totalMaster = $data->userPlan()->plan()->plan_value * (1 / 100);
                    $totalPay = $totalMaster;

                    while ($totalMaster > 0) {

                        $planActive = UserPlan::where([
                            ['user_id', $check->id],
                            ['status', 1],
                            ['is_20', 1]
                        ])->orderBy('created_at', 'asc')->first();

                        if($planActive) {
                            $valuePlanActive = $planActive->plan()->plan_value;
                            $justChecking = (($planActive->profit() * 10 / 100) * $valuePlanActive);
                            $maxProfit = ($config['max_profit'] - $config['max_donate']) / ($config['max_receive'] - $config['max_donate']);

                            if ($planActive->profit() >= $maxProfit || ($justChecking + $check->earnings_bonus) < ($valuePlanActive * ($config['max_profit'] / 100) )) {

                                if(($justChecking + $check->earnings_bonus) + $totalMaster > ($valuePlanActive * ($config['max_profit'] / 100) )) {
                                    $totalPay = ($valuePlanActive * ($config['max_profit'] / 100) ) - ($justChecking + $check->earnings_bonus);

                                    $planActive->status = 3;
                                    $planActive->save();
                                }

                                if($totalPay > 0) {
                                    Bonus::create([
                                        'user_id'        => $check->id,
                                        'transaction_id' => $data->id,
                                        'value'          => $totalPay
                                    ]);

                                    if($planActive->status == 3) {
                                        User::where('id', $check->id)
                                            ->update(['earnings_bonus' => 0]);
                                    } else {
                                        User::where('id', $check->id)
                                            ->increment('earnings_bonus', $totalPay);
                                    }
                                }

                                $totalMaster -= $totalPay;

                            } else {
                                $planActive->status = 3;
                                $planActive->save();
                            }
                        } else {
                            break;
                        }

                    }
                } else {
                    echo 'save on missing bonus table as father master';
                }
            }

            //Level 3
            $check = $check->indication();
            echo $check . '<br>';

            $masterActivePlan = UserPlan::where([
                ['user_id', $check->id],
                ['status', 1],
                ['is_20', 1]
            ])->count();

            if($check->level != 1) {
                if($masterActivePlan > 0) {
                    $totalMaster = $data->userPlan()->plan()->plan_value * (1 / 100);
                    $totalPay = $totalMaster;

                    while ($totalMaster > 0) {

                        $planActive = UserPlan::where([
                            ['user_id', $check->id],
                            ['status', 1],
                            ['is_20', 1]
                        ])->orderBy('created_at', 'asc')->first();

                        if($planActive) {
                            $valuePlanActive = $planActive->plan()->plan_value;
                            $justChecking = (($planActive->profit() * 10 / 100) * $valuePlanActive);
                            $maxProfit = ($config['max_profit'] - $config['max_donate']) / ($config['max_receive'] - $config['max_donate']);

                            if ($planActive->profit() >= $maxProfit || ($justChecking + $check->earnings_bonus) < ($valuePlanActive * ($config['max_profit'] / 100) )) {

                                if(($justChecking + $check->earnings_bonus) + $totalMaster > ($valuePlanActive * ($config['max_profit'] / 100) )) {
                                    $totalPay = ($valuePlanActive * ($config['max_profit'] / 100) ) - ($justChecking + $check->earnings_bonus);

                                    $planActive->status = 3;
                                    $planActive->save();
                                }

                                if($totalPay > 0) {
                                    Bonus::create([
                                        'user_id'        => $check->id,
                                        'transaction_id' => $data->id,
                                        'value'          => $totalPay
                                    ]);

                                    if($planActive->status == 3) {
                                        User::where('id', $check->id)
                                            ->update(['earnings_bonus' => 0]);
                                    } else {
                                        User::where('id', $check->id)
                                            ->increment('earnings_bonus', $totalPay);
                                    }
                                }

                                $totalMaster -= $totalPay;

                            } else {
                                $planActive->status = 3;
                                $planActive->save();
                            }
                        } else {
                            break;
                        }
                    }
                } else {
                    echo 'save on missing bonus table as father master';
                }
            }

            //Level 4
            $check = $check->indication();
            echo $check . '<br>';

            $masterActivePlan = UserPlan::where([
                ['user_id', $check->id],
                ['status', 1],
                ['is_20', 1]
            ])->count();

            if($check->level != 1) {
                if($masterActivePlan > 0) {
                    $totalMaster = $data->userPlan()->plan()->plan_value * (1 / 100);
                    $totalPay = $totalMaster;

                    while ($totalMaster > 0) {

                        $planActive = UserPlan::where([
                            ['user_id', $check->id],
                            ['status', 1],
                            ['is_20', 1]
                        ])->orderBy('created_at', 'asc')->first();

                        if($planActive) {
                            $valuePlanActive = $planActive->plan()->plan_value;
                            $justChecking = (($planActive->profit() * 10 / 100) * $valuePlanActive);
                            $maxProfit = ($config['max_profit'] - $config['max_donate']) / ($config['max_receive'] - $config['max_donate']);

                            if ($planActive->profit() >= $maxProfit || ($justChecking + $check->earnings_bonus) < ($valuePlanActive * ($config['max_profit'] / 100) )) {

                                if(($justChecking + $check->earnings_bonus) + $totalMaster > ($valuePlanActive * ($config['max_profit'] / 100) )) {
                                    $totalPay = ($valuePlanActive * ($config['max_profit'] / 100) ) - ($justChecking + $check->earnings_bonus);

                                    $planActive->status = 3;
                                    $planActive->save();
                                }

                                if($totalPay > 0) {
                                    Bonus::create([
                                        'user_id'        => $check->id,
                                        'transaction_id' => $data->id,
                                        'value'          => $totalPay
                                    ]);

                                    if($planActive->status == 3) {
                                        User::where('id', $check->id)
                                            ->update(['earnings_bonus' => 0]);
                                    } else {
                                        User::where('id', $check->id)
                                            ->increment('earnings_bonus', $totalPay);
                                    }
                                }

                                $totalMaster -= $totalPay;

                            } else {
                                $planActive->status = 3;
                                $planActive->save();
                            }
                        } else {
                            break;
                        }

                    }
                } else {
                    echo 'save on missing bonus table as father master';
                }
            }

            //Level 1
            if($fatherActivePlan > 0) {
                /*
                $total = $data->userPlan()->plan()->plan_value * (5 / 100);
                Bonus::create([
                    'user_id' => $father->id,
                    'transaction_id' => $data->id,
                    'value' => $total,
                ]);
                echo 'bonus father created';
                */

                echo '<br><br> === Level 1 === <br><br>';

                $total = $data->userPlan()->plan()->plan_value * (5 / 100);
                $totalPay = $total;

                while ($total > 0) {

                    $planActive = UserPlan::where([
                        ['user_id', $father->id],
                        ['status', 1],
                        ['is_20', 1]
                    ])->orderBy('created_at', 'asc')->first();

                    echo $planActive . '<br>';
                    echo 'Rest total: ' . $total;

                    if($planActive) {
                        $valuePlanActive = $planActive->plan()->plan_value;
                        $justChecking = (($planActive->profit() * 10 / 100) * $valuePlanActive);
                        $maxProfit = ($config['max_profit'] - $config['max_donate']) / ($config['max_receive'] - $config['max_donate']);

                        if ($planActive->profit() >= $maxProfit || ($justChecking + $father->earnings_bonus) < ($valuePlanActive * ($config['max_profit'] / 100) )) {

                            if(($justChecking + $father->earnings_bonus) + $total > ($valuePlanActive * ($config['max_profit'] / 100) )) {
                                $totalPay = ($valuePlanActive * ($config['max_profit'] / 100) ) - ($justChecking + $father->earnings_bonus);
                                echo 'TotalPay: ' . $totalPay;

                                $planActive->status = 3;
                                $planActive->save();
                            }

                            if($totalPay > 0) {
                                Bonus::create([
                                    'user_id'        => $father->id,
                                    'transaction_id' => $data->id,
                                    'value'          => $totalPay
                                ]);

                                if($planActive->status == 3) {
                                    User::where('id', $father->id)
                                        ->update(['earnings_bonus' => 0]);
                                } else {
                                    User::where('id', $father->id)
                                        ->increment('earnings_bonus', $totalPay);
                                }

                            }

                            $total -= $totalPay;

                        } else {
                            $planActive->status = 3;
                            $planActive->save();
                        }
                    } else {
                        break;
                    }
                }
            } else {
                echo 'save on missing bonus table as common user';
            }

            $reponse = true;
        }

        return true;

    }

    public function leaders()
    {
        $config = $this->config();

        $firstDayofPreviousMonth = Carbon::now()->startOfMonth()->subMonth()->toDateString();
        $lastDayofPreviousMonth = Carbon::now()->subMonth()->endOfMonth()->toDateString();

        $req = UserPlan::where([
            ['status', '=', 1],
            ['created_at', '>=', $firstDayofPreviousMonth],
            ['created_at', '<=', $lastDayofPreviousMonth . ' 23:59:59'],
            //['created_at', '>=', '2020-12-01']
        ])->get();

        $result = [];

        foreach($req as $val){
            $checkIfIsNew = UserPlan::where([
                //['status', '=', 1],
                ['created_at', '<', $val['created_at']],
                ['user_id', $val['user_id']]
                //['created_at', '>=', '2020-12-01']
            ]);

            if(substr($checkIfIsNew->first()['created_at'],0,7) == substr($val['created_at'],0,7) || $checkIfIsNew->get()->count() == 0) {
                if(array_key_exists($val->user()->indication()->id, $result)) {
                    $result[$val->user()->indication()->id] += $val->plan()->plan_value;
                } else {
                    $result[$val->user()->indication()->id] = $val->plan()->plan_value;
                }
            }
        }

        $usersMaster = [];

        foreach ($result as $key => $value) {
            if($value >= 5000) {
                $earning = floatval($value * (5 / 100));

                Bonus::create([
                    'user_id' => $key,
                    'value' => $earning,
                    'description' => 'Master Bonus',
                    'plan_id' => 0
                ]);

                $user = User::where('id', $key)->first();

                if($user->is_leader == 2) {
                    User::where('id', $key)
                        ->increment('earnings_master', $earning);

                    User::where('id', $key)
                        ->where('id', $user->id)
                        ->update(['master' => 3]);
                } else {
                    User::where('id', $key)
                        ->increment('earnings_master', $earning, ['is_leader' => 1]);

                    User::where('id', $key)
                        ->increment('master', 1);
                }

                array_push($usersMaster, $key);

            }
        }

        $resetMaster = User::whereNotIn('id', $usersMaster)->get();

        foreach ($resetMaster as $master) {
            $master->master = 0;
            $master->save();
        }

    }

    public function criarDoacao()
    {

        $config = $this->config();

        $bonus = Bonus::where('value', 0)->get();

        foreach ($bonus as $key => $value) {
            $transaction = Transaction::where('id', $value->transaction_id)->first();
            $this->bonusUpdate($transaction, $value->id, $config);
        }

    }

    public function bonusUpdate($data, $id, $config)
    {
        echo 'generating bonus <br>';

        $donating = $data->userPlan()->user();

        $father = $donating->indication();

        $fatherActivePlan = UserPlan::where([['user_id', $father->id], ['status', 1]])->count();

        if ($father->level != 1) {

            echo 'father is not master <br>';

            //Level 2
            $check = $father->indication();
            echo $check . '<br>';

            $masterActivePlan = UserPlan::where([['user_id', $check->id], ['status', 1]])->count();

            if($check->level != 1) {
                if($masterActivePlan > 0) {
                    $totalMaster = $data->userPlan()->plan()->plan_value * (1 / 100);
                    Bonus::where('id', $id)->update(['value' => $totalMaster], ['timestamps' => false]);
                    /*
                    Bonus::create([
                        'user_id' => $check->id,
                        'transaction_id' => $data->id,
                        'value' => $totalMaster
                    ]);
                    */
                    echo 'bonus master created <br>';
                } else {
                    echo 'save on missing bonus table as father master';
                }
            }

            //Level 3
            $check = $check->indication();
            echo $check . '<br>';

            $masterActivePlan = UserPlan::where([['user_id', $check->id], ['status', 1]])->count();

            if($check->level != 1) {
                if($masterActivePlan > 0) {
                    $totalMaster = $data->userPlan()->plan()->plan_value * (1 / 100);
                    Bonus::where('id', $id)->update(['value' => $totalMaster], ['timestamps' => false]);
                    /*
                    Bonus::create([
                        'user_id' => $check->id,
                        'transaction_id' => $data->id,
                        'value' => $totalMaster
                    ]);
                    */
                    echo 'bonus master created <br>';
                } else {
                    echo 'save on missing bonus table as father master';
                }
            }

            //Level 4
            $check = $check->indication();
            echo $check . '<br>';

            $masterActivePlan = UserPlan::where([['user_id', $check->id], ['status', 1]])->count();

            if($check->level != 1) {
                if($masterActivePlan > 0) {
                    $totalMaster = $data->userPlan()->plan()->plan_value * (1 / 100);
                    Bonus::where('id', $id)->update(['value' => $totalMaster], ['timestamps' => false]);
                    /*
                    Bonus::create([
                        'user_id' => $check->id,
                        'transaction_id' => $data->id,
                        'value' => $totalMaster
                    ]);
                    */
                    echo 'bonus master created <br>';
                } else {
                    echo 'save on missing bonus table as father master';
                }
            }

            //Level 1
            if($fatherActivePlan > 0) {
                $total = $data->userPlan()->plan()->plan_value * (5 / 100);
                Bonus::where('id', $id)->update(['value' => $totalMaster], ['timestamps' => false]);
                /*
                Bonus::create([
                    'user_id' => $father->id,
                    'transaction_id' => $data->id,
                    'value' => $total,
                ]);
                */
                echo 'bonus father created';
            } else {
                echo 'save on missing bonus table as common user';
            }

            $reponse = true;
        }

        return true;

    }
}
