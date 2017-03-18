<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderPivot extends Pivot
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
    protected $fillable = ['serial_number', 'status', 'status_info'];

    /**
     * 取得購買此訂單的用戶。
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * 取得此訂單購買的活動。
     */
    public function activity()
    {
        return $this->belongsTo('App\Models\Activity');
    }
    
    /**
     * 取得此訂單的交易紀錄。
     */
    public function transactions()
    {
        return $this->hasMany(
            'App\Models\Transaction',
            'order_serial_number',
            'serial_number'
        );
    }
}
