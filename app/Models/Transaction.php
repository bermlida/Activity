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
     * 設定付款資訊。
     *
     * @param  array|object  $value
     * @return string
     */
    public function setPaymentInfoAttribute($value)
    {
        $value = is_array($value) || is_object($value) ? $value : null;

        $this->attributes['payment_info'] = json_encode($value);
    }

    /**
     * 設定付款結果。
     *
     * @param  array|object  $value
     * @return string
     */
    public function setPaymentResultAttribute($value)
    {
        $value = is_array($value) || is_object($value) ? $value : null;
        
        $this->attributes['payment_result'] = json_encode($value);
    }

    /**
     * 取得付款資訊。
     *
     * @param  string|null  $value
     * @return object
     */
    public function getPaymentInfoAttribute($value)
    {
        return json_decode($value);
    }

    /**
     * 取得付款結果。
     *
     * @param  string|null  $value
     * @return object
     */
    public function getPaymentResultAttribute($value)
    {
        return json_decode($value);
    }

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

    /**
     * 取得此交易紀錄對應的退款帳戶。
     */
    public function financial_account()
    {
        return $this->morphOne('App\Models\FinancialAccount', 'associated');
    }

    /**
     * 限制查詢串接金流的交易紀錄。
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeConnectPaymentFlow($query)
    {
        return $query
                    ->whereNotNull('payment_info')
                    ->orWhereNotNull('payment_result');
    }

    /**
     * 限制查詢特定狀態的交易紀錄。
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
