<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;

use Auth;
use App\User;
use App\UserPlan;
use App\Bonus;
use App\BonusRequest;
use App\Donation;

class BonusController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $config = $this->config();
        $bonus_paginate  = Bonus::where('user_id', Auth::id())->orderBy('id','DESC')->get();
        $bonus        = Bonus::where('user_id', Auth::id())->orderBy('id','DESC')->get();
        $bonusRequest = BonusRequest::where('user_id', Auth::id())->orderBy('id','DESC')->get();

        $saques         = [];
        $dateSaques     = [];
        $toRequest      = 0;
        $totalPending   = 0;
        $totalConfirmed = 0;
        $total          = 0;

        foreach ($bonus as $key => $value) {
            if($value->status != 0) {
                if(!in_array($value->updated_at, $dateSaques)) {
                    array_push($saques, $value);
                    array_push($dateSaques, $value->updated_at);
                }

                foreach($bonusRequest as $requested) {
                    if($value->updated_at->format('Y-m-d H:i') == $requested->created_at->format('Y-m-d H:i')) {
                        $value->requested = $requested;
                    }
                }
            }

            if($value->status == 0) {
                $toRequest += $value->value;
            } elseif($value->status == 1) {
                $totalPending += $value->value;
            } elseif($value->status == 2) {
                $totalConfirmed += $value->value;
            }

            $total += $value->value;
        }

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $itemCollection = collect($bonus);
        $perPage = 15;
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
        $bonus = new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
        $bonus->setPath($request->url());

        return view('bonus.index', [
            'config'         => $config,
            'reports'        => $bonus,
            'reports_paginate'  => $bonus_paginate,
            'reports_req'    => $bonusRequest,
            'request'        => $toRequest,
            'totalPending'   => $totalPending,
            'totalConfirmed' => $totalConfirmed,
            'total'          => $total,
            'saques'         => $saques,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $config = $this->config();

        $bonus = Bonus::where([['user_id', Auth::id()],['status', 0]]);
        //get all bonus with status = 0
        $total = $bonus->sum('value');

        if ($total < $config['min_bonus_request']) {
            return redirect()->back()->withError([

            ]);
        }

        $request_bonus = $bonus->get();
        $has10 = false;

        foreach ($request_bonus as $key => $value) {
            if(!$value->is_20) {$has10 = true;}

            $value->status = 1;
            $value->save();
        }

        //Create donation
        if($has10) {
            $donation = Donation::create([
                'user_id' => Auth::id(),
                'total' => $total,
                'bonus' => 1,
                'status' => 80,
                'is_20' => 0
            ]);
        } else {
            $donation = Donation::create([
                'user_id' => Auth::id(),
                'total' => $total,
                'bonus' => 1,
            ]);
        }

        BonusRequest::create([
            'user_id' => Auth::id(),
            'donation_id' => $donation->id,
            'value' => $total
        ]);
        //Save on bonus request

        return back()->withStatus('');
    }

    public function master()
    {

        $config = $this->config();

        $firstDayofPreviousMonth = Carbon::now()->startOfMonth()->subMonth(5)->toDateString();
        $lastDayofPreviousMonth = Carbon::now()->subMonth(0)->endOfMonth()->toDateString();

        $req = UserPlan::select('user_plans.*')
                ->join('users', 'user_plans.user_id', '=', 'users.id')
                ->where([
                    ['users.indication_id', '=', Auth::id()],
                    ['user_plans.status', '=', 1],
                    ['user_plans.created_at', '>=', $firstDayofPreviousMonth],
                    ['user_plans.created_at', '<=', $lastDayofPreviousMonth . ' 23:59:59'],
                    //['user_plans.created_at', '>=', '2020-12-01']
                ])
                ->get();

        $result     = [];
        $usersUsed  = [];
        $totalSales = [];
        $lastMonth = null;

        foreach($req as $val){
            $checkIfIsNew = UserPlan::where([
                //['status', '=', 1],
                ['created_at', '<', $val['created_at']],
                ['user_id', $val['user_id']]
                //['created_at', '>=', '2020-12-01']
            ]);
            
            if(substr($checkIfIsNew->first()['created_at'],0,7) == substr($val['created_at'],0,7) || $checkIfIsNew->get()->count() == 0 || substr($checkIfIsNew->first()['created_at'],0,7) == '2021-04' && substr($val['created_at'],0,10) == '2021-05-01') {
                
                if(substr($val['created_at'],0,10) == '2021-05-01') {
                    $val['created_at'] = '2021-04-30';
                }
                
                if(substr($val['created_at'],0,7) != $lastMonth) {
                    if(!in_array($val['user_id'], $usersUsed)) {
                        if(array_key_exists(substr($val['created_at'],0,7), $result)) {
                            $result[substr($val['created_at'],0,7)][] = $val;
                            $totalSales[substr($val['created_at'],0,7)] += $val->plan()->plan_value;
                        } else {
                            $result[substr($val['created_at'],0,7)][]=$val;
                            $totalSales[substr($val['created_at'],0,7)] = $val->plan()->plan_value;
                            array_push($usersUsed, $val['user_id']);
                        }
                    }
                } else {
                    if(array_key_exists(substr($val['created_at'],0,7), $result)) {
                        $result[substr($val['created_at'],0,7)][] = $val;
                        $totalSales[substr($val['created_at'],0,7)] += $val->plan()->plan_value;
                    } else {
                        $result[substr($val['created_at'],0,7)][] = $val;
                        $totalSales[substr($val['created_at'],0,7)] = $val->plan()->plan_value;
                        array_push($usersUsed, $val['user_id']);
                    }
                }

                $lastMonth = substr($val['created_at'],0,7);
            }
        }
        
        collect($result)->sortBy('date')->reverse()->toArray();
        collect($totalSales)->sortBy('date')->reverse()->toArray();
        $result     = array_reverse($result);
        $totalSales = array_reverse($totalSales);
        
        $keys = array_keys($result);

        return view('bonus.master', [
            'config' => $config,
            'reports' => $result,
            'totalSales' => $totalSales,
            'keys' => $keys
        ]);
    }

    public function referrals()
    {
        $config = $this->config();
        $referrals = User::select('users.*')
            ->where([
                ['users.indication_id', Auth::id()],
                //['user_plans.status', '<>', 1]
            ])
            ->orderBy('created_at', 'desc')->paginate(15);

        foreach($referrals as $key => $value) {
            $checkPlanActive = UserPlan::where([
                ['user_id', $value->id],
                ['status', 1]
            ])->get();

            if(!$checkPlanActive->isEmpty()) {
                unset($referrals[$key]);
            }
        }  

        //dd($referrals);  

        return view('bonus.referrals', [
            'config'    => $config,
            'referrals' => $referrals
        ]);
    }
    
}
