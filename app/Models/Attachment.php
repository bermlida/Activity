<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attachment extends Model
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
        'name', 'type', 'size', 'path',
        'url', 'secure_url',
        'category', 'description'
    ];
    
    /**
     * 取得所有所屬的可擁有附件的模型。
     */
    public function attached()
    {
        return $this->morphTo();
    }

    /**
     * 限制查詢類別為宣傳圖片的附件。
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIsBanner($query)
    {
        return $query->where('category', 'banner');
    }

    /**
     * 限制查詢特定類別的附件。
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}
