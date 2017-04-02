<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Activity;

class ActivityController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * 顯示已發佈活動的列表畫面。
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['activities'] = Activity::ofStatus(1)->paginate(1);
        
        return view('activities', $data);
    }

    /**
     * 顯示已發佈活動的資訊畫面。
     *
     * @return \Illuminate\Http\Response
     */
    public function info($activity)
    {
        $activity = Activity::find($activity);

        $activity_banner = $activity->attachments()->where('category', 'banner')->first();

        $data = [
            'activity' => $activity,
            'activity_banner' => $activity_banner
        ];

        return view('activity', $data);
    }
}
