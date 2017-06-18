<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FinancialAccount extends Model
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
        'financial_institution_code',
        'account_number'
    ];
    
    /**
     * 取得與金融帳戶相關聯的資料模型。
     */
    public function associated()
    {
        return $this->morphTo();
    }
}
