<?php

namespace App\Models;

use Carbon\Carbon;
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
     * 設定活動開始時間。
     *
     * @param  string|null  $value
     * @return string
     */
    public function setStartTimeAttribute($value)
    {
        $value = is_string($value) ? $value . ':00' : $value;
        
        $this->attributes['start_time'] = $value;
    }

    /**
     * 設定活動結束時間。
     *
     * @param  string|null  $value
     * @return string
     */
    public function setEndTimeAttribute($value)
    {
        $value = is_string($value) ? $value . ':00' : $value;
        
        $this->attributes['end_time'] = $value;
    }

    /**
     * 設定報名開始時間。
     *
     * @param  string|null  $value
     * @return string
     */
    public function setApplyStartTimeAttribute($value)
    {
        $value = is_string($value) ? $value . ':00' : $value;
        
        $this->attributes['apply_start_time'] = $value;
    }

    /**
     * 設定報名結束時間。
     *
     * @param  string|null  $value
     * @return string
     */
    public function setApplyEndTimeAttribute($value)
    {
        $value = is_string($value) ? $value . ':00' : $value;
        
        $this->attributes['apply_end_time'] = $value;
    }

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
     * 取得此活動的附件。
     */
    public function attachments()
    {
        return $this->morphMany('App\Models\Attachment', 'attached');
    }
    
    /**
     * 取得此活動擁有的訊息。
     */
    public function messages()
    {
        return $this->hasMany('App\Models\Message');
    }
    
    /**
     * 取得此活動擁有的日誌。
     */
    public function logs()
    {
        return $this->hasMany('App\Models\Log');
    }
    
    /**
     * 取得購買此活動的訂單。
     */
    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    /**
     * 限制查詢已上架的活動。
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLaunched($query)
    {
        return $query->where('status', 1);
    }

    /**
     * 限制查詢尚未發布的活動(草稿)。
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDrafting($query)
    {
        return $query->where('status', 0);
    }

    /**
     * 限制查詢已下架的活動。
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDiscontinued($query)
    {
        return $query->where('status', -1);
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
