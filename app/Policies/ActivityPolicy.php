<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use App\Models\Account;
use App\Models\Activity;

class ActivityPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * 。
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return bool
     */
    public function apply(Account $account, Activity $activity)
    {
        if ($account->role_id == 1) {
            return is_null($account->profile) || $account->profile->activities()
                ->where('activity_id', $activity->id)
                ->wherePivot('status', 1)
                ->count() == 0;
        }

        return false;
    }
}
