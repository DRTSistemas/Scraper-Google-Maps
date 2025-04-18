<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Http\Requests\PasswordRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;

use Auth;
use App\User;
use App\Plan;
use App\UserPlan;
use App\Transaction;

class UserAdminController extends BaseController
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
        $users = User::where('level', 0)->get();

        $plans = Plan::where('active', 1)->get();

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

        return view('admin.users.index',
            [
                'users' => $users,
                'plans' => $plans,
                'totalUsersWithActivePlan' => $totalUsersWithActivePlan,
                'totalUsersWithoutRequests' => $totalUsersWithoutRequests,
                'totalRevenue' => $totalRevenue
            ]
        );
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

        try {
            // Criar usuário
            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'country_code' => '+55',
                'phone_number' => $request->phone_number,
                'password' => Hash::make($request->password),
                'level' => intval($request->level) ?? 0, // Se não informado, padrão é 0
            ]);

            return back()->with('status', 'Usuário criado com sucesso!');
        } catch (\Exception $e) {
            $message = $e->getMessage();
        
            // Mensagens legíveis para o usuário
            if (str_contains($message, 'users_username_unique')) {
                $userMessage = 'Este nome de usuário já está em uso.';
            } elseif (str_contains($message, 'users_email_unique')) {
                $userMessage = 'Este e-mail já está cadastrado.';
            } else {
                $userMessage = 'Erro ao criar o usuário. Por favor, tente novamente.';
            }
        
            return back()->with('error', $userMessage);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!$this->checkAdmin()){
            return redirect()->route('login');
        }

        return view('admin.users.show', ['user' => User::find($id), 'config' => $this->config()]);
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

        $user = User::findOrFail($id);

        // Filtra apenas os campos não vazios
        $data = array_filter($request->all(), function ($value) {
            return !is_null($value) && $value !== '';
        });
        
        // Atualiza os dados do usuário, exceto requests_left
        unset($data['requests_left']);
        
        // Gera a hash da senha, se existir
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        
        $user->update($data);

        // Obtém o valor de requests_left enviado na requisição
        $newRequests = (int) $request->input('requests_left');

        // ⚡ Se $newRequests for negativo, reduz dos planos mais antigos
        if ($newRequests < 0) {
            $remainingToDeduct = abs($newRequests); // Transforma em positivo para facilitar o cálculo
            $userPlans = $user->userPlans()->orderBy('created_at', 'asc')->get();

            foreach ($userPlans as $userPlan) {
                if ($remainingToDeduct <= 0) break;

                if ($userPlan->requests_left >= $remainingToDeduct) {
                    $userPlan->decrement('requests_left', $remainingToDeduct);
                    $remainingToDeduct = 0;
                } else {
                    $remainingToDeduct -= $userPlan->requests_left;
                    $userPlan->update(['requests_left' => 0]);
                }
            }
        }

        // ⚡ Se $newRequests for positivo, adiciona um novo plano (ou recarga)
        if ($newRequests > 0) {
            // Encontrar um plano adequado baseado na divisão plan_value / search_value
            $plan = Plan::get()->first(function ($plan) use ($newRequests) {
                return round($plan->plan_value / $plan->search_value) == $newRequests;
            });

            if ($plan) {
                UserPlan::create([
                    'user_id' => $user->id,
                    'plan_id' => $plan->id,
                    'status' => 1,
                    'requests_left' => $newRequests
                ]);
            }
        }

        return back()->withStatus(__('Usuário atualizado com sucesso'));
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

        $user = User::find($id);

        $user->delete();



        return back()->withStatus('Usuário Deletado');
    }

    public function access($id, $sha1)
    {
        if(substr(sha1($id), -4) == $sha1) {
            session(['impersonate' => $id]);
            $auth = Auth::loginUsingId($id);
        }
        return redirect()->to('/');
    }
}
