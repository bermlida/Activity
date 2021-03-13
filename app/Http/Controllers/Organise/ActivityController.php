<?php

namespace App\Http\Controllers\Organise;

use Auth;
use Storage;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreActivityRequest;
use App\Models\Activity;
use App\Services\FileUploadService;

class ActivityController extends Controller
{
    /**
     * 顯示主辦單位舉辦活動的列表畫面。
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $organizer = Auth::user()->profile;

        $data['launched_activities'] = $organizer->activities()
            ->launched()
            ->where('end_time', '>=', Carbon::now())
            ->orderBy('start_time')->orderBy('end_time')
            ->paginate(10, ['*'], 'launched_page');

        $data['discontinued_activities'] = $organizer->activities()
            ->discontinued()
            ->orderBy('start_time')->orderBy('end_time')
            ->paginate(10, ['*'], 'discontinued_page');

        $data['drafting_activities'] = $organizer->activities()
            ->drafting()
            ->orderBy('updated_at', 'desc')
            ->paginate(10, ['*'], 'drafting_page');

        $data['ended_activities'] = $organizer->activities()
            ->launched()
            ->where('end_time', '<', Carbon::now())
            ->orderBy('start_time')->orderBy('end_time')
            ->paginate(10, ['*'], 'ended_page');

        $data['url_query'] = $request->only([
            'launched_page', 'discontinued_page', 'drafting_page', 'ended_page'
        ]);

        $data['tab'] = $request->has('tab') ? $request->input('tab') : 'launched';
        
        return view('organise.activities', $data);
    }

    /**
     * 顯示單一活動的資訊畫面。
     *
     * @return \Illuminate\Http\Response
     */
    public function info($activity)
    {
        $data['organizer'] = (Auth::user())->profile;
        
        $data['activity'] = $data['organizer']->activities()->find($activity);

        $data['activity_banner'] = $data['activity']->attachments()->IsBanner()->first();

        return view('organise.activity-info', $data);
    }

    /**
     * 顯示單一活動的預覽畫面。
     *
     * @return \Illuminate\Http\Response
     */
    public function preview($activity, Request $request)
    {
        $data['info'] = Activity::find($activity);

        $data['banner'] = $data['info']->attachments()->IsBanner()->first();

        $data['logs'] = $data['info']->logs()->where('status', 1)->paginate(10, ['*'], 'logs_page');

        $data['logs_page'] = $request->only('logs_page');

        $data['tab'] = $request->has('tab') ? $request->input('tab') : 'introduce';

        return view('activity', $data);
    }

    /**
     * 顯示單一活動的新增 / 編輯畫面。
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($activity = null)
    {
        $data['organizer'] = (Auth::user())->profile;
        
        if (!is_null($activity)) {
            $data['activity'] = $data['organizer']->activities()->find($activity);

            $data['activity_banner'] = $data['activity']->attachments()->IsBanner()->first();

            $data['page_method'] = 'PUT';
        } else {
            $data['page_method'] = 'POST';
        }

        return view('organise.activity', $data);
    }

    /**
     * 新增單一活動。
     *
     * @return \Illuminate\Http\Response
     */
    public function create(StoreActivityRequest $request)
    {
        $organizer = (Auth::user())->profile;

        $activity = new Activity($request->all());

        if ($organizer->activities()->save($activity)) {
            if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
                $photo = $request->file('photo');

                app(FileUploadService::class)->uploadActivityBanner($photo, $activity);
            }

            return redirect()
                ->route('organise::activity::modify', [$activity])
                ->with([
                    'message_type' => 'success',
                    'message_body' => '新增成功'
                ]);
        } else {
            return back()->withInput()->with([
                'message_type' => 'warning',
                'message_body' => '新增失敗'
            ]);
        }

    }

    /**
     * 更新單一活動。
     *
     * @return \Illuminate\Http\Response
     */
    public function update($activity, StoreActivityRequest $request)
    {
        $organizer = (Auth::user())->profile;

        $activity = $organizer->activities()->find($activity);

        $result = $activity->fill($request->all())->save();

        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $photo = $request->file('photo');

            app(FileUploadService::class)->uploadActivityBanner($photo, $activity);
        }
        
        if ($result) {
            return redirect()
                ->route('organise::activity::modify', [$activity])
                ->with([
                    'message_type' => 'success',
                    'message_body' => '更新成功'
                ]);
        } else {
            return back()->withInput()->with([
                'message_type' => 'warning',
                'message_body' => '更新失敗'
            ]);
        }
    }

    /**
     * 刪除單一活動。
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($activity)
    {
        $organizer = (Auth::user())->profile;

        $activity = $organizer->activities()->find($activity);

        $data['result'] = $activity->delete();

        $data['message'] = $data['result'] ? '刪除成功' : '刪除失敗';

        return response()->json($data);
    }

    /**
     * 發布單一活動
     *
     * @return \Illuminate\Http\Response
     */
    public function publish($activity)
    {
        $organizer = Auth::user()->profile;

        $activity = $organizer->activities()->find($activity);

        $activity->status = 1;

        $data['result'] = $activity->save();

        $data['message'] = $data['result'] ? '活動已發布' : '活動發布失敗';

        return response()->json($data);
    }

    /**
     * 設定單一活動的狀態為上架。
     *
     * @return \Illuminate\Http\Response
     */
    public function launch($activity)
    {
        $organizer = Auth::user()->profile;

        $activity = $organizer->activities()->find($activity);

        $activity->status = 1;

        $data['result'] = $activity->save();

        $data['message'] = $data['result'] ? '活動已上架' : '活動上架失敗';

        return response()->json($data);
    }

    /**
     * 設定單一活動的狀態為下架。
     *
     * @return \Illuminate\Http\Response
     */
    public function discontinue($activity)
    {
        $organizer = Auth::user()->profile;

        $activity = $organizer->activities()->find($activity);

        $activity->status = -1;

        $data['result'] = $activity->save();

        $data['message'] = $data['result'] ? '活動已下架' : '活動下架失敗';

        return response()->json($data);
    }
}
