<?php

namespace App\Http\Controllers\Organise;

use Auth;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ActivityLogController extends Controller
{
    /**
     * 取得單一活動的日誌列表。
     *
     * @return \Illuminate\Http\Response
     */
    public function index($activity, Request $request)
    {
        $organizer = (Auth::user())->profile;

        $activity = $organizer->activities()->find($activity);

        $data['launched_logs'] = $activity
            ->logs()
            ->where('status', 1)
            ->paginate(10, ['*'], 'launched_page');

        $data['draft_logs'] = $activity
            ->logs()
            ->where('status', 0)
            ->paginate(10, ['*'], 'draft_page');

        $data['postponed_logs'] = $activity
            ->logs()
            ->where('status', -1)
            ->paginate(10, ['*'], 'postponed_page');

        $data['url_query'] = $request->only('launched_page', 'draft_page', 'postponed_page');

        $data['tab'] = $request->has('tab') ? $request->input('tab') : 'launched';
        
        return view('organise.activity-logs', $data);
    }

    /**
     * 顯示單一日誌的新增 / 編輯畫面。
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($activity, $log = null)
    {
        $organizer = (Auth::user())->profile;

        $activity = $organizer->activities()->find($activity);
        
        if (!is_null($log)) {
            $data['log'] = $activity->logs()->find($log);

            $data['log_content'] = $data['log']->attachments()->ofCategory('log')->first();

            $data['page_method'] = 'PUT';
        } else {
            $data['page_method'] = 'POST';
        }

        return view('organise.activity-log', $data);
    }

    /**
     * 發布單一日誌。
     *
     * @return \Illuminate\Http\Response
     */
    public function publish($activity, $log)
    {
        $organizer = (Auth::user())->profile;

        $activity = $organizer->activities()->find($activity);

        $log = $activity->logs()->find($log);

        $log->status = 1;

        $data['result'] = $log->save();

        $data['message'] = $data['result'] ? '日誌已發布' : '日誌發布失敗';

        return response()->json($data);
    }

    /**
     * 刪除單一日誌。
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($activity, $log)
    {
        $organizer = (Auth::user())->profile;

        $activity = $organizer->activities()->find($activity);

        $log = $activity->logs()->find($log);

        $data['result'] = $log->delete();

        $data['message'] = $data['result'] ? '刪除成功' : '刪除失敗';

        return response()->json($data);
    }
}
