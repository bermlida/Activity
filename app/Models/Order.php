<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Pivot
{
    use SoftDeletes;

    /**
     * 需要被轉換成日期的屬性。
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    
    /**
     * 取得此訂單的交易紀錄。
     */
    public function transations()
    {
        return $this->hasMany('App\Models\Transation');
    }
}
