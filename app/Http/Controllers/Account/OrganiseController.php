<?php

namespace App\Http\Controllers\Account;

use Auth;
use Storage;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\Models\Activity;

class OrganiseController extends Controller
{
    /**
     * 顯示主辦單位舉辦活動的列表畫面。
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

            $activity_banner = $activity->attachments()->where('category', 'banner')->first();

            if (!is_null($activity)) {
                $data['activity'] = $activity;

                $data['activity_banner'] = $activity_banner;
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
            $this->storeBanner($activity, $request);

            return redirect()
                ->route('organise::activity', [$activity])
                ->with([
                    'message_type' => 'success',
                    'message_body' => '新增成功'
                ]);
        } else {
            $request->flash();

            $request->session()->flash('message_type', 'warning');

            $request->session()->flash('message_body', '新增失敗');

            $data = [
                'orgznizer' => $organizer,
                'page_method' => 'POST'
            ];
            
            return view('account.organise-activity', $data);
        }

    }

    /**
     * 更新單一活動。
     *
     * @return \Illuminate\Http\Response
     */
    public function update($activity, UpdateActivityRequest $request)
    {
        $organizer = (Auth::user())->profile;

        $activity = $organizer->activities()->find($activity);

        $update_result = $activity->fill($request->all())->save();
            
        $store_banner_result = $this->storeBanner($activity, $request);
        
        if ($update_result && $store_banner_result) {
            return redirect()
                ->route('organise::activity', [$activity])
                ->with([
                    'message_type' => 'success',
                    'message_body' => '更新成功'
                ]);
        } else {
            $request->flash();

            $request->session()->flash('message_type', 'warning');

            $request->session()->flash('message_body', '更新失敗');

            $data = [
                'organizer' => $organizer,
                'activity' => $activity,
                'page_method' => 'PUT'
            ];

            return view('account.organise-activity', $data);
        }
    }

    protected function storeBanner(Activity $activity, $request)
    {
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $file = $request->file('photo');
            $stored_path = public_path('storage/banners/');
            $stored_filename = 'activity-' . $activity->id . '.' . $file->getClientOriginalExtension();

            $data = [
                'name' => $stored_filename,
                'type' => $file->getMimeType(),
                'size' => $file->getClientSize(),
                'path' => $stored_path . $stored_filename,
                'category' => 'banner',
                'description' => ''
            ];
            
            if ($activity->attachments()->where('category', 'banner')->count() > 0) {
                $attachment = $activity->attachments()
                    ->where('category', 'banner')
                    ->first();

                $attachment->update($data);
            } else {
                $activity->attachments()->create($data);
            }

            $file->move($stored_path, $stored_filename);

            return true;
        }

        return !$request->hasFile('photo');
    }
}
