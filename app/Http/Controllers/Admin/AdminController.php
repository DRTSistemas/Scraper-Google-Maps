<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

use Auth;
use Carbon\Carbon;
use App\User;
use App\UserPlan;
use App\Transaction;

class AdminController extends BaseController

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

        // Total de usuários com level igual a 0
        $users = User::where('level', 0)->count();

        // Total de usuários com level 0 e pelo menos um plano com requests_left > 0
        $totalUsersWithActivePlan = User::where('level', 0)
        ->whereHas('userPlans', function ($query) {
            $query->where('requests_left', '>', 0);
        })
        ->count();

        // Total de usuários com level 0 que:
        // - Não possuem nenhum plano OU
        // - Possuem apenas planos com requests_left = 0
        $totalUsersWithoutRequests = User::where('level', 0)
        ->whereDoesntHave('userPlans', function ($query) {
            $query->where('requests_left', '>', 0); // Se ele tem qualquer plano com requests_left > 0, ele não entra aqui
        })
        ->count();

        // Soma o valor de todos os planos associados aos UserPlan
        $totalRevenue = UserPlan::with('plan') // Carrega os planos relacionados
        ->get()
        ->sum(fn($userPlan) => $userPlan->plan ? $userPlan->plan->plan_value : 0);

        return view('admin.dashboard', [
            'users' => $users,
            'totalUsersWithActivePlan' => $totalUsersWithActivePlan,
            'totalUsersWithoutRequests' => $totalUsersWithoutRequests,
            'totalRevenue' => $totalRevenue
        ]);

    }

    public function removeTransaction(Request $request)
    {
        $transaction = Transaction::find($request->input('transactionId'));
        if(is_null($transaction->who_requested)) {
            $transaction->who_requested = auth()->user()->id;
            $transaction->save();

            return response()->json(['success' => true]);
        }

        return response()->json([
            'success' => false,
            'transaction' => $request->input('transactionId')
        ]);
    }

    public function returnTransaction(Request $request)
    {
        $transaction = Transaction::find($request->input('transactionId'));
        if($transaction->who_requested == auth()->user()->id) {
            $transaction->who_requested = null;
            $transaction->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }

    public function reportMasters()
    {

        if(!$this->checkAdmin()) {
            return redirect()->route('login');
        }

        $start    = new \DateTime(Carbon::now()->subMonth(6)->toDateTimeString());
        $end      = new \DateTime(Carbon::now()->addMonth(1)->toDateTimeString());
        $interval = \DateInterval::createFromDateString('1 month'); // 1 month interval
        $period   = new \DatePeriod($start, $interval, $end);

        $months = array();

        foreach ($period as $dt) {
            $months[] = $dt->format("F Y");
        }

        $months = array_reverse($months);

        $month = isset($_GET['month']) ? $_GET['month'] : 0;

        $firstDayofPreviousMonth = Carbon::now()->startOfMonth()->subMonth($month)->toDateString();
        $lastDayofPreviousMonth = Carbon::now()->subMonth($month)->endOfMonth()->toDateString();

        $req = UserPlan::where([
            ['status', '=', 1],
            ['created_at', '>=', $firstDayofPreviousMonth],
            ['created_at', '<=', $lastDayofPreviousMonth . ' 23:59:59'],
            //['created_at', '>=', '2020-12-01']
        ])->get();

        $result = [];
        $masters = [];
        $total = 0;

        foreach($req as $val){
            $checkIfIsNew = UserPlan::where([
                //['status', '=', 1],
                ['created_at', '<', $val['created_at']],
                ['user_id', $val['user_id']]
                //['created_at', '>=', '2020-12-01']
            ]);

            if(substr($checkIfIsNew->first()['created_at'],0,7) == substr($val['created_at'],0,7) || $checkIfIsNew->get()->count() == 0 || substr($checkIfIsNew->first()['created_at'],0,7) == '2021-04' && substr($val['created_at'],0,10) == '2021-05-01') {

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

                if(!in_array($key, $usersMaster)) {

                    $user = User::where('id', $key)->first();

                    if(array_key_exists($key, $masters)) {
                        $masters[$key][0] += $earning;
                        $masters[$key][1] += $user;
                        $masters[$key][2] += $value;
                    } else {
                        $masters[$key][0] = $earning;
                        $masters[$key][1] = $user;
                        $masters[$key][2] = $value;
                    }

                    $total += $earning;

                    array_push($usersMaster, $key);
                }
            }
        }

        $topMaster = User::where([
            ['earnings_master', '>', 0],
            ['level', 0]
        ])->orderBy('earnings_master', 'desc')->first();

        return view('admin.payments.masters', [
            'masters' => $masters,
            'total'   => $total,
            'topMaster' => $topMaster,
            'months'  => $months
        ]);
    }

    public function getPaymentDiamonds()
    {

        if(!$this->checkAdmin()) {
            return redirect()->route('login');
        }

        $firstDayofPreviousMonth = Carbon::now()->startOfMonth()->subMonth()->toDateString();
        $lastDayofPreviousMonth = Carbon::now()->subMonth()->endOfMonth()->toDateString();

        $req = UserPlan::where([
            ['status', '=', 1],
            ['created_at', '>=', $firstDayofPreviousMonth],
            ['created_at', '<=', $lastDayofPreviousMonth . ' 23:59:59'],
            //['created_at', '>=', '2020-12-01']
        ])->get();

        $usersDiamond = User::where([
            ['master', 3]
        ])->get();

        $made = 0;

        foreach($req as $val){
            $checkIfIsNew = UserPlan::where([
                //['status', '=', 1],
                ['created_at', '<', $val['created_at']],
                ['user_id', $val['user_id']]
                //['created_at', '>=', '2020-12-01']
            ]);

            if(substr($checkIfIsNew->first()['created_at'],0,7) == substr($val['created_at'],0,7) || $checkIfIsNew->get()->count() == 0) {
                $made += $val->plan()->plan_value;
            }
        }

        $topDiamond = User::where([
            ['earnings_diamond', '>', 0],
            ['level', 0]
        ])->orderBy('earnings_diamond', 'desc')->first();

        return view('admin.payments.diamonds', [
            'made' => $made,
            'topDiamond' => $topDiamond,
            'users' => $usersDiamond
        ]);
    }

    public function paymentDiamonds(Request $request)
    {

        if(!$this->checkAdmin()) {
            return redirect()->route('login');
        }

        $usersDiamond = User::where([
            ['master', 3]
        ])->get();

        $valuePerUser = floatval($request->input('total') * (2 / 100)) / $usersDiamond->count();

        foreach($usersDiamond as $user) {
            Bonus::create([
                'user_id' => $user->id,
                'value' => $valuePerUser,
                'description' => 'Diamond Bonus',
                'plan_id' => 0
            ]);

            User::where('id', $user->id)
            ->increment('earnings_diamond', $valuePerUser, ['master' => 0, 'is_leader' => 2]);
        }

        return back()->withStatus(__('Diamond payments made successfully.'));

    }

    public function totalActivations(Request $request)
    {

        if(!$this->checkAdmin()) {
            return redirect()->route('login');
        }

        $start    = new \DateTime(Carbon::now()->subMonth(6)->toDateTimeString());
        $end      = new \DateTime(Carbon::now()->addMonth(1)->toDateTimeString());
        $interval = \DateInterval::createFromDateString('1 month'); // 1 month interval
        $period   = new \DatePeriod($start, $interval, $end);

        $months = array();

        foreach ($period as $dt) {
            $months[] = $dt->format("F Y");
        }

        $months = array_reverse($months);

        $month = isset($_GET['month']) ? $_GET['month'] : 0;

        $firstDayofPreviousMonth = Carbon::now()->startOfMonth()->subMonth($month)->toDateString();
        $lastDayofPreviousMonth = Carbon::now()->subMonth($month)->endOfMonth()->toDateString();

        $req = UserPlan::where([
            ['status', '=', 1],
            ['created_at', '>=', $firstDayofPreviousMonth],
            ['created_at', '<=', $lastDayofPreviousMonth . ' 23:59:59'],
            //['created_at', '>=', '2020-12-01']
        ])->orderBy('created_at','DESC')->get();

        $made = 0;
        $activations = [];

        foreach($req as $val){
            $checkIfIsNew = UserPlan::where([
                //['status', '=', 1],
                ['created_at', '<', $val['created_at']],
                ['user_id', $val['user_id']]
                //['created_at', '>=', '2020-12-01']
            ]);

            if(substr($checkIfIsNew->first()['created_at'],0,7) == substr($val['created_at'],0,7) || $checkIfIsNew->get()->count() == 0) {
                $made += $val->plan()->plan_value;
                $activations[] = $val;
            }
        }

        /*
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $itemCollection = collect($activations);
        $perPage = 15;
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
        $activations = new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
        $activations->setPath($request->url());
        */

        return view('admin.payments.activations', [
            'activations' => $activations,
            'made'        => $made,
            'months'      => $months
        ]);
    }

}

