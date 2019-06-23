<?php

namespace App\Http\Controllers\Organise;

use Auth;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ActivityApplicantController extends Controller
{
    /**
     * 取得單一活動的報名列表。
     *
     * @return \Illuminate\Http\Response
     */
    public function index($activity, Request $request)
    {
        $organizer = (Auth::user())->profile;

        $activity = $organizer->activities()->find($activity);

        $data['completed_orders'] = $activity->orders()
            ->where('status', 1)
            ->paginate(10, ['*'], 'completed_page');

        $data['paid_orders'] = $activity->orders()
            ->where('status', 1)
            ->whereHas('transactions', function ($query) {
                $query->where('status', 1);
            })
            ->paginate(10, ['*'], 'paid_page');

        $data['refunding_orders'] = $activity->orders()
            ->where('status', -1)
            ->whereHas('transactions', function ($query) {
                $query
                    ->where('status', -1)
                    ->whereNotNull('payment_result');
            })
            ->paginate(10, ['*'], 'refunding_page');

        $data['url_query'] = $request->only('completed_page', 'paid_page', 'refunding_page');

        $data['tab'] = $request->has('tab') ? $request->input('tab') : 'completed';
        
        return view('organise.activity-applicants', $data);
    }
}
