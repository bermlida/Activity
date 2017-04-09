<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use SoftDeletes;

    /**
     * 需要被轉換成日期的屬性。
     *
     * @var array
     */
    protected $dates = [
        'start_time', 'end_time',
        'apply_start_time', 'apply_end_time',
        'deleted_at'
    ];

    /**
     * 可以被批量賦值的屬性。
     *
     * @var array
     */
    protected $fillable = [
        'name', 'start_time', 'end_time', 'venue', 'venue_intro',
        'apply_start_time', 'apply_end_time',
        'can_sponsored', 'is_free', 'apply_fee',
        'summary', 'intro', 'status'
    ];

    /**
     * 建立中介資料表的模型。
     *
     * @param  \Illuminate\Database\Eloquent\Model  $parent
     * @param  array  $attributes
     * @param  string  $table
     * @param  bool  $exists
     * @return \Illuminate\Database\Eloquent\Relations\Pivot
     */
    public function newPivot(Model $parent, array $attributes, $table, $exists)
    {
        if ($parent instanceof User) {
            return new OrderPivot($parent, $attributes, $table, $exists);
        }

        return parent::newPivot($parent, $attributes, $table, $exists);
    }

    /**
     * 取得舉辦此活動的主辦單位。
     */
    public function organizer()
    {
        return $this->belongsTo('App\Models\Organizer');
    }

    /**
     * 取得參加活動的使用者。
     */
    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'orders')
                    ->withPivot('serial_number', 'status', 'status_info')
                    ->withTimestamps();
    }
    
    /**
     * 取得購買此活動的訂單。
     */
    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    /**
     * 取得此活動的附件。
     */
    public function attachments()
    {
        return $this->morphMany('App\Models\Attachment', 'attached');
    }

    /**
     * 限制查詢只包括給定主辦單位的活動。
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfOrganizer($query, $organizer)
    {
        return $query->where('organizer_id', $organizer);
    }

    /**
     * 限制查詢只包括給定狀態的活動。
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
