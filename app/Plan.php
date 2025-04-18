<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'name', 'search_value', 'plan_value', 'link_checkout'
    ];

    public function userPlan()
    {
        return $this->hasMany(UserPlan::class, 'id', 'plan_id')->first();
    }
}
