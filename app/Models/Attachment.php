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
        'category', 'description'
    ];
    
    /**
     * 取得所有所屬的可擁有附件的模型。
     */
    public function attached()
    {
        return $this->morphTo();
    }
}
