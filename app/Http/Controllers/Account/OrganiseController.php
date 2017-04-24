<?php

namespace App\Http\Controllers\Account;

use Auth;
use Storage;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreActivityRequest;
// use App\Http\Requests\UpdateActivityRequest;
use App\Models\Activity;

class OrganiseController extends Controller
{
    /**
     * 顯示主辦單位舉辦活動的列表畫面。
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $organizer = Auth::user()->profile;

        $data['going_activities'] = $organizer->activities()
            ->going()
            ->orderBy('start_time')->orderBy('end_time')
            ->paginate(1, ['*'], 'going_page');

        $data['draft_activities'] = $organizer->activities()
            ->ofStatus(0)
            ->orderBy('updated_at', 'desc')
            ->paginate(1, ['*'], 'draft_page');

        $data['ended_activities'] = $organizer->activities()
            ->ended()
            ->orderBy('start_time')->orderBy('end_time')
            ->paginate(1, ['*'], 'ended_page');

        $data['url_query'] = $request->only('going_page', 'draft_page', 'ended_page');

        $data['tab'] = $request->has('tab') ? $request->input('tab') : 'going';
        
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
            $data['activity'] = $data['organizer']->activities()->find($activity);

            $data['activity_banner'] = $data['activity']->attachments()->IsBanner()->first();

            $data['page_method'] = 'PUT';
        } else {
            $data['page_method'] = 'POST';
        }

        return view('account.organise-activity', $data);
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
            if ($this->storeBanner($activity, $request)) {
                return redirect()
                    ->route('organise::activity::modify', [$activity])
                    ->with([
                        'message_type' => 'success',
                        'message_body' => '新增成功'
                    ]);
            }
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
    public function update($activity, StoreActivityRequest $request)
    {
        $organizer = (Auth::user())->profile;

        $activity = $organizer->activities()->find($activity);

        $update_result = $activity->fill($request->all())->save();
            
        $store_banner_result = $this->storeBanner($activity, $request);
        
        if ($update_result && $store_banner_result) {
            return redirect()
                ->route('organise::activity::modify', [$activity])
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
     * 取得單一活動的報名列表。
     *
     * @return \Illuminate\Http\Response
     */
    public function applicants($activity, Request $request)
    {
        $organizer = (Auth::user())->profile;

        $activity = $organizer->activities()->find($activity);

        $data['completed_orders'] = $activity->orders()
            ->where('status', 1)
            ->paginate(1, ['*'], 'completed_page');

        $data['undone_orders'] = $activity->orders()
            ->where('status', 0)
            ->doesntHave('transactions')
            ->paginate(1, ['*'], 'undone_page');

        $data['unpaid_orders'] = $activity->orders()
            ->where('status', 0)
            ->has('transactions')
            ->paginate(1, ['*'], 'unpaid_page');

        $data['url_query'] = $request->only('completed_page', 'undone_page', 'unpaid_page');

        $data['tab'] = $request->has('tab') ? $request->input('tab') : 'completed';
        
        return view('account.applicants', $data);
    }
}
