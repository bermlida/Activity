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
    protected $dates = ['deleted_at'];

    /**
     * 可以被批量賦值的屬性。
     *
     * @var array
     */
    protected $fillable = [
        'name', 'start_time', 'end_time', 'venue', 'venue_intro',
        'summary', 'intro'
    ];

    /**
     * 取得舉辦此活動的主辦單位。
     */
    public function organizer()
    {
        return $this->belongsTo('App\Models\Organizer');
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
}
