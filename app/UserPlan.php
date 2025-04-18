<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPlan extends Model
{
    protected $fillable = [
        'user_id', 'plan_id', 'status', 'requests_left'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id')->first();
    }

    public function plan()
    {
        return $this->hasOne(Plan::class, 'id', 'plan_id');
    }
}
