<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
     * 取得使用者帳號。
     */
    public function account()
    {
        return $this->morphMany('App\Models\Account', 'profile');
    }
}
