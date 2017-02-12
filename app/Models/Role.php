<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
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
    protected $fillable = ['name'];

    /**
     * 取得符合此角色的帳號。
     */
    public function accounts()
    {
        return $this->hasMany('App\Models\Accounts');
    }
}
