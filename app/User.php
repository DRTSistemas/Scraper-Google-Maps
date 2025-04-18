<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Lab404\Impersonate\Models\Impersonate;
use App\Notifications\ForgotPassword;

class User extends Authenticatable
{
    use Notifiable;
    use Impersonate;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'name', 'email', 'password', 'level', 'indication_id', 'country_code', 'phone_number', 'google2fa_secret', 'api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'google2fa_secret'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ForgotPassword($token));
    }

    /**
     * @param $authy_id string
     */
    public function updateAuthyId($authy_id) {
        if($this->authy_id != $authy_id) {
            $this->authy_id = $authy_id;
            $this->save();
        }
    }

    public function userPlan()
    {
        return $this->hasMany(UserPlan::class, 'id', 'user_id')->first();
    }

    public function userPlans()
    {
        return $this->hasMany(UserPlan::class, 'user_id', 'id')->orderBy('created_at', 'asc');
    }

    public function totalRequestsLeft()
    {
        return $this->userPlans()->sum('requests_left');
    }

    public function updateOldestPlanRequests($value)
    {
        // Obtém o plano mais antigo do usuário
        $oldestPlan = $this->userPlans()->where('requests_left', '>', 0)->first();

        if ($oldestPlan) {
            // Atualiza o requests_left somando ou subtraindo o valor passado
            $oldestPlan->increment('requests_left', $value);
        }
    }

    public function hasActivePlan()
    {
        // Verifica se existe algum plano onde `requests_left > 0`
        return $this->userPlans()->where('requests_left', '>', 0)->exists();
    }

    public function planAdmin()
    {
        return $this->hasMany(UserPlan::class, 'user_id', 'id')->first();
    }

    public function wallet()
    {
        return $this->hasMany(Wallet::class, 'user_id', 'id')->where('active', 1)->first();
    }

    public function indication()
    {
        return $this->hasOne(User::class, 'id', 'indication_id')->first();
    }

    public function country()
    {
        return $this->hasOne(Country::class, 'phonecode', 'country_code')->first();
    }

     /**
     * Ecrypt the user's google_2fa secret.
     *
     * @param  string  $value
     * @return string
     */
    public function setGoogle2faSecretAttribute($value)
    {
         $this->attributes['google2fa_secret'] = encrypt($value);
    }

    /**
     * Decrypt the user's google_2fa secret.
     *
     * @param  string  $value
     * @return string
     */
    public function getGoogle2faSecretAttribute($value)
    {
        if (!empty($value)) {
            return decrypt($value);
        }
    }

    public function canImpersonate()
    {
        // For example
        return $this->attributes['level'] == 1;

    }

    public function canBeImpersonated()
    {
        // For example
        return $this->attributes['level'] == 0;
    }

}
