<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Account extends Authenticatable
{
    use SoftDeletes, Notifiable;

    /**
     * 需要被轉換成日期的屬性。
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * 可以被批量賦值的屬性。
     *
     * @var array
     */
    protected $fillable = ['email', 'password'];

    /**
     * Route notifications for the Nexmo channel.
     *
     * @return string
     */
    public function routeNotificationForNexmo()
    {
        return $this->profile->mobile_phone;
    }
    
    /**
     * 取得此帳號的基本資料。
     */
    public function profile()
    {
        return $this->morphTo();
    }

    /**
     * 取得此帳號的授權角色類型。
     */
    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }
}
