<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use SoftDeletes;

    /**
     * 需要被轉換成日期的屬性。
     *
     * @var array
     */
    protected $dates = [
        'sending_time',
        'deleted_at'
    ];

    /**
     * 可以被批量賦值的屬性。
     *
     * @var array
     */
    protected $fillable = [
        'subject', 'content',
        'sending_method', 'sending_target', 'sending_time',
        'status'
    ];

    /**
     * 設定發送時間。
     *
     * @param  string|null  $value
     * @return string
     */
    public function setSendingTimeAttribute($value)
    {
        $value = is_string($value) ? $value . ':00' : $value;
        
        $this->attributes['sending_time'] = $value;
    }

    /**
     * 設定發送方式。
     *
     * @param  array  $value
     * @return string
     */
    public function setSendingMethodAttribute(array $value)
    {
        $this->attributes['sending_method'] = json_encode($value);
    }

    /**
     * 設定發送對象。
     *
     * @param  array  $value
     * @return string
     */
    public function setSendingTargetAttribute(array $value)
    {
        $this->attributes['sending_target'] = json_encode($value);
    }

    /**
     * 取得發送方式。
     *
     * @param  string  $value
     * @return array
     */
    public function getSendingMethodAttribute($value)
    {
        return json_decode($value, true);
    }

    /**
     * 取得發送對象。
     *
     * @param  string  $value
     * @return array
     */
    public function getSendingTargetAttribute($value)
    {
        return json_decode($value, true);
    }
    
    /**
     * 取得此訊息對應的活動。
     */
    public function activity()
    {
        return $this->belongsTo('App\Models\Activity');
    }

    /**
     * 限制查詢只包括給定活動的訊息。
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfActivity($query, $activity)
    {
        return $query->where('activity_id', $activity);
    }

    /**
     * 限制查詢已列入排程但尚未發送的訊息。
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeScheduled($query)
    {
        return $query
                ->where('status', 1)
                ->whereNotNull('sending_time')
                ->where('sending_time', '>=', Carbon::now()->format('Y-m-d H:i'));
    }

    /**
     * 限制查詢已發送的訊息。
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSent($query)
    {
        return $query
                ->where('status', 1)
                ->whereNull('sending_time')
                ->orWhere(function ($query) {
                    $query
                        ->whereNotNull('sending_time')
                        ->where('sending_time', '<', Carbon::now()->format('Y-m-d H:i'));
                });
    }
}
