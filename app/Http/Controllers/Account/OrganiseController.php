<?php

namespace App\Http\Controllers\Account;

use Auth;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\Models\Activity;

class OrganiseController extends Controller
{
    /**
     * 顯示舉辦活動的列表畫面。
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['activities'] = (Auth::user())->profile->activities;
        
        return view('account.organise-activities', $data);
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
            $activity = $data['organizer']->activities()->find($activity);

            if (!is_null($activity)) {
                $data['activity'] = $activity;
            }
        }

        $data['page_method'] = isset($data['activity']) ? 'PUT' : 'POST';

        return view('account.organise-activity', $data);
    }

    /**
     * 新增單一活動。
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CreateActivityRequest $request)
    {
        $organizer = (Auth::user())->profile;

        $activity = new Activity($request->all());

        if ($organizer->activities()->save($activity)) {
            $save_result['result'] = true;
            $save_result['message'] = '新增成功';
            $page_method = 'PUT';
        } else {
            $save_result['result'] = false;
            $save_result['message'] = '新增失敗';
            $page_method = 'POST';
        }
        
        $data = compact('organizer', 'activity', 'page_method', 'save_result');

        return view('account.organise-activity', $data);
    }

    /**
     * 更新單一活動。
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateActivityRequest $request)
    {
        $organizer = (Auth::user())->profile;

        $activity = $organizer->activities()->find($request->activity_id);

        if (is_null($activity)) {
            $activity = new Activity($request->all());

            $update_result = $organizer->activities()->save($activity);
        } else {
            $update_result = $activity->fill($request->all())->save();
        }
        
        $save_result['result'] = $update_result;
        $save_result['message'] = $update_result ? '更新失敗' : '更新成功';
        $page_method = 'PUT';

        $data = compact('organizer', 'activity', 'page_method', 'save_result');

        return view('account.organise-activity', $data);
    }
}
