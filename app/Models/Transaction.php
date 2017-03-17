<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
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
    protected $fillable = [
        'serial_number',
        'apply_fee', 'sponsorship_amount',
        'payment_info', 'payment_result',
        'status', 'status_info'
    ];

    /**
     * 取得此交易紀錄對應的訂單。
     */
    public function order()
    {
        return $this->belongsTo(
            'App\Models\Order',
            'order_serial_number',
            'serial_number'
        );
    }
}
