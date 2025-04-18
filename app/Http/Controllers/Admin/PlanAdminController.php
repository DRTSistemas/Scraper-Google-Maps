<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

use Auth;
use App\Plan;
use App\UserPlan;
use Carbon\Carbon;

class PlanAdminController extends BaseController

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



        return view('admin.plans.index', ['plans' => Plan::where('active', 1)->orderBy('search_value', 'asc')->paginate(15), 'config' => $this->config()]);

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

        $data = $request->validate([

            "name" => "required",

            "search_value" => "required",

            "plan_value" => "required",

            "link_checkout" => "required",

        ]);


        Plan::create($data);



        return back()->withStatus('Plano Criado');

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

        if(!$this->checkAdmin()){

            return redirect()->route('login');

        }


        $plan = Plan::find($id);



        $data = $request->validate([

            "name" => "required",

            "search_value" => "required",

            "plan_value" => "required",

            "link_checkout" => "required",

        ]);



        $plan->update($data);



        return back()->withStatus('Plano atualizado');

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

        

        $plan = Plan::find($id);



        $plan->active = 0;

        $plan->save();



        return back()->withStatus('Plano Deletado');

    }

    public function activations()
    {
        if(!$this->checkAdmin()){
            return redirect()->route('login');
        }

        $from = isset($_GET['from']) ? $_GET['from'] : '01'.date('/m/Y');
        $to   = isset($_GET['to']) ? $_GET['to'] : date('d/m/Y');  

        $formatFrom = $this->dateEmMysql($from);
        $formatTo   = $this->dateEmMysql($to);

        $activations = UserPlan::where([
            ['status', 1],
            ['created_at', '>=', Carbon::parse($formatFrom)->toDateString() . ' 00:00:00'],
            ['created_at', '<=', Carbon::parse($formatTo)->toDateString() . ' 23:59:00'],
        ])->orderBy('created_at', 'desc');

        $activationsTotal = UserPlan::where([
            ['status', 1],
        ])->orderBy('created_at', 'desc');

        $donationsPerDay = [];
        $total = 0;
        $totalAll = 0;

        foreach($activations->get() as $a) {
            $total += $a->plan()->plan_value;

            $date = date('Y-m-d', strtotime($a->created_at));

            if(array_key_exists($date, $donationsPerDay)) {
                $donationsPerDay[$date] += $a->plan()->plan_value;
            } else {
                $donationsPerDay[$date] = $a->plan()->plan_value;
            }
        }

        foreach($activationsTotal->get() as $a) {
            $totalAll += $a->plan()->plan_value;
        }

        //$donationsPerDay = array_reverse($donationsPerDay);

        return view('admin.plans.activations', [
            'activations' => $activations->get(), 
            'total'           => $total,
            'totalAll'        => $totalAll,
            'from'            => $from,
            'to'              => $to,
            'donationsPerDay' => $donationsPerDay,
            'config' => $this->config()
        ]);

    }

    public static function dateEmMysql($dateSql){
        $ano= substr($dateSql, 6);
        $mes= substr($dateSql, 3,-5);
        $dia= substr($dateSql, 0,-8);
        return $ano."-".$mes."-".$dia;
    }

}

