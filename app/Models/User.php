<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class User extends Model
{
    use SoftDeletes, Notifiable;

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
        'mobile_country_calling_code',
        'mobile_phone'
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
        if ($parent instanceof Activity) {
            return new OrderPivot($parent, $attributes, $table, $exists);
        }

        return parent::newPivot($parent, $attributes, $table, $exists);
    }

    /**
     * 取得使用者的帳號資訊。
     */
    public function account()
    {
        return $this->morphOne('App\Models\Account', 'profile');
    }

    /**
     * 取得使用者的金融帳戶。
     */
    public function financial_account()
    {
        return $this->morphOne('App\Models\FinancialAccount', 'associated');
    }

    /**
     * 取得使用者參加的活動。
     */
    public function activities()
    {
        return $this->belongsToMany('App\Models\Activity', 'orders')
                    ->withPivot('serial_number', 'status', 'status_info')
                    ->withTimestamps();
    }
    
    /**
     * 取得使用者購買的訂單。
     */
    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }
}
