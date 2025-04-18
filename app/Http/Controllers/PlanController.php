<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Auth;
use App\Plan;
use App\UserPlan;

class PlanController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if($this->checkAdmin()) {
            return redirect()->route('admin.index');
        }
        
        // Obtém o ID do plano atual do usuário, se existir
            $currentPlanId = UserPlan::where('user_id', Auth::id())
            ->where('status', 1) // Considere o status ativo como 1
            ->orderBy('id', 'asc')
            ->value('plan_id'); // Supondo que a coluna seja 'plan_id'

        // Obtém o valor do plano atual, se existir
        $currentPlanValue = null;
        if ($currentPlanId) {
            $currentPlanValue = Plan::where('id', $currentPlanId)->value('search_value');
        }

        // Busca o próximo plano disponível
        $nextPlanQuery = Plan::where('active', 1)->orderBy('search_value', 'asc');

        if ($currentPlanValue) {
            $nextPlanQuery->where('search_value', '>', $currentPlanValue);
        }

        $nextPlan = $nextPlanQuery->first();

        // Se nenhum próximo plano for encontrado, retorna o menor plano disponível
        if (!$nextPlan) {
            $nextPlan = Plan::where('active', 1)->orderBy('search_value', 'asc')->first();
        }

        return view('plans.index', [
            'plan' => $nextPlan, 
            'config' => $this->config()
        ]);
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
        $plan_id = $request->plan;

        UserPlan::create([
            'plan_id' => $plan_id,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('wallet.index');
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
        //
    }
}
