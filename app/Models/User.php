<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use SoftDeletes;

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
    protected $fillable = ['name', 'mobile_phone'];

    /**
     * 取得使用者的帳號資訊。
     */
    public function account()
    {
        return $this->morphMany('App\Models\Account', 'profile');
    }
}
