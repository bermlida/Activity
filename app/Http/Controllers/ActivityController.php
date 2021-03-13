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
     * 顯示已發布活動的列表畫面。
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['activities'] = Activity::with('attachments')
            ->ofStatus(1)
            ->paginate(12);
        
        return view('activities', $data);
    }

    /**
     * 顯示已發布活動的資訊畫面。
     *
     * @return \Illuminate\Http\Response
     */
    public function info($activity, Request $request)
    {
        $data['info'] = Activity::find($activity);

        $data['banner'] = $data['info']->attachments()->IsBanner()->first();

        $data['logs'] = $data['info']->logs()->where('status', 1)->paginate(10, ['*'], 'logs_page');

        $data['logs_page'] = $request->only('logs_page');

        $data['tab'] = $request->has('tab') ? $request->input('tab') : 'introduce';

        return view('activity', $data);
    }

    /**
     * 顯示已發布活動的日誌內容。
     *
     * @return \Illuminate\Http\Response
     */
    public function log($activity, $log)
    {
        $data['info'] = Activity::find($activity);

        $data['log'] = $data['info']->logs()->find($log);

        $data['log_content'] = $data['log']
            ->attachments()
            ->ofCategory($data['log']->content_type . '_content')
            ->first();

        return view('activity-log', $data);
    }
}
