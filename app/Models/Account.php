<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use SoftDeletes;

    /**
     * 需要被轉換成日期的屬性。
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    
    /**
     * 取得帳號基本資料。
     */
    public function profile()
    {
        return $this->morphTo();
    }
}
