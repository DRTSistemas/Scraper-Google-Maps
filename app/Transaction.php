<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //donation_id = Doação a qual essa trasação foi criada -> user_id de quem vai receber e user_plan_id de quem vai receber
    //user_plan_id = Plano de quem está doando
    //to_user_id = id do usuário de quem vai receber
    //to_wallet_id = id da carteira de quem vai receber

    protected $fillable = [
        'user_plan_id',
        'donation_id',
        'to_user_id',
        // 'to_user_plan_id',
        'value',
        'to_wallet_id',
        'who_requested'
    ];

    public function plan()
    {
        return $this->hasMany(Plan::class, 'id', 'user_plan_id')->first();
    }

    public function userPlan()
    {
        return $this->hasMany(UserPlan::class, 'id', 'user_plan_id')->first();
    }

    public function donation()
    {
        return $this->hasMany(Donation::class, 'id', 'donation_id')->first();
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'to_user_id')->first();
    }

    public function whoRequested()
    {
        return $this->hasOne(User::class, 'id', 'who_requested')->first();
    }

    // public function toUserPlan()
    // {
    //     return $this->hasMany(UserPlan::class, 'id', 'to_user_plan_id')->first();
    // }

    // public function userTransactions($user_id)
    // {
    //     return $this->join('user_plans', 'transactions.user_plan_id', '=', 'user_plans.id')
    //     ->where('user_plans.user_id', $user_id)->get();
    // }

}
