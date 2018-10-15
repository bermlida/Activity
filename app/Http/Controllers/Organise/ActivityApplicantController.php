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

        $data['unrefund_orders'] = $activity->orders()
            ->where('status', -1)
            ->whereHas('transactions', function ($query) {
                $query->where('status', 1);
            })
            ->paginate(10, ['*'], 'unrefund_page');

        $data['refunded_orders'] = $activity->orders()
            ->where('status', -1)
            ->whereHas('transactions', function ($query) {
                $query->where('status', 1);
            })
            ->paginate(10, ['*'], 'refunded_page');

        $data['url_query'] = $request->only('completed_page', 'unrefund_page', 'refunded_page');

        $data['tab'] = $request->has('tab') ? $request->input('tab') : 'completed';
        
        return view('organise.activity-applicants', $data);
    }
}
