<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organizer extends Model
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
        'name',
        'address',
        'phone', 'fax',
        'mobile_country_calling_code', 'mobile_phone',
        'intro'
    ];

    /**
     * 取得主辦單位的帳號資訊。
     */
    public function account()
    {
        return $this->morphOne('App\Models\Account', 'profile');
    }

    /**
     * 取得主辦單位的金融帳戶。
     */
    public function financial_account()
    {
        return $this->morphOne('App\Models\FinancialAccount', 'associated');
    }

    /**
     * 取得與主辦單位有關的附件。
     */
    public function attachments()
    {
        return $this->morphMany('App\Models\Attachment', 'attached');
    }
    
    /**
     * 取得主辦單位舉辦的活動。
     */
    public function activities()
    {
        return $this->hasMany('App\Models\Activity');
    }
}
