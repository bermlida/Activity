<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Log extends Model
{
    use SoftDeletes;
    
    /**
     * 可以被批量賦值的屬性。
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'content_type', 'content',
        'status'
    ];
    
    /**
     * 取得此日誌對應的活動。
     */
    public function activity()
    {
        return $this->belongsTo('App\Models\Activity');
    }

    /**
     * 取得此日誌的附件。
     */
    public function attachments()
    {
        return $this->morphMany('App\Models\Attachment', 'attached');
    }

    /**
     * 限制查詢只包括給定活動的日誌。
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfActivity($query, $activity)
    {
        return $query->where('activity_id', $activity);
    }
}
