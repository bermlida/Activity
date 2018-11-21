<?php

namespace App\Http\Controllers\Organise;

use DB;
use Auth;
use Illuminate\Http\Request;

use App\Models\Log;
use App\Http\Requests;
use App\Services\FileUploadService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreActivityLogRequest;

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

        $data['activity'] = $organizer->activities()->find($activity);

        $data['published_logs'] = $data['activity']
            ->logs()
            ->where('status', 1)
            ->paginate(10, ['*'], 'published_page');

        $data['draft_logs'] = $data['activity']
            ->logs()
            ->where('status', 0)
            ->paginate(10, ['*'], 'draft_page');

        $data['url_query'] = $request->only('published_page', 'draft_page');

        $data['tab'] = $request->has('tab') ? $request->input('tab') : 'published';
        
        return view('organise.activity-logs', $data);
    }

    /**
     * 顯示單一日誌的新增 / 編輯畫面。
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($activity, $log = null)
    {
        $data['organizer'] = (Auth::user())->profile;

        $data['activity'] = $data['organizer']->activities()->find($activity);
        
        if (!is_null($log)) {
            $data['log'] = $data['activity']->logs()->find($log);

            $data['log_content'] = $data['log']
                                    ->attachments()
                                    ->ofCategory($data['log']->content_type . '_content')
                                    ->first();

            $data['form_action'] = route('organise::activity::log::update', ['activity' => $activity, 'log' => $log]);

            $data['form_method'] = 'PUT';

            $data['page_title'] = '編輯活動日誌';
        } else {
            $data['form_action'] = route('organise::activity::log::store', ['activity' => $activity]);

            $data['form_method'] = 'POST';

            $data['page_title'] = '新增活動日誌';
        }

        return view('organise.activity-log', $data);
    }

    /**
     * 儲存單一活動訊息。
     *
     * @return \Illuminate\Http\Response
     */
    public function save(StoreActivityLogRequest $request, $activity, $log = null)
    {
        $organizer = (Auth::user())->profile;

        $activity = $organizer->activities()->find($activity);

        $log = !is_null($log)
                ? $activity->logs()->find($log)->fill($request->all())
                : new Log($request->all());
        
        if ($log->content_type == 'blog' || $request->hasFile('plog_content') || $request->hasFile('vlog_content')) {
            $result = DB::transaction(function () use ($activity, $log, $request) {
                if ($log->attachments()->where('category', 'like', '%_content')->count() > 0) {
                    unlink($log->attachments()->where('category', 'like', '%_content')->first()->path);

                    $log->attachments()->where('category', 'like', '%_content')->first()->delete();
                }

                if ($log->content_type == 'plog' || $log->content_type == 'vlog') {
                    $upload_file = $request->file($log->content_type . '_content');

                    if (!is_null($upload_file)) {
                        $stored_path = public_path('storage/' . $activity->id . '/' . $log->content_type . 's/');

                        $activity->logs()->save($log->fill(['content' => null]));

                        $log->attachments()->create([
                            'name' => $upload_file->getClientOriginalName(),
                            'type' => $upload_file->getMimeType(),
                            'size' => $upload_file->getClientSize(),
                            'path' => $stored_path . $upload_file->getClientOriginalName(),
                            'category' => $log->content_type . '_content',
                            'description' => ''
                        ]);

                        app(FileUploadService::class)->storeFile(
                            $upload_file,
                            $stored_path,
                            $upload_file->getClientOriginalName()
                        );

                        return true;
                    }
                } else {
                    $log->content = $request->input('blog_content');
                }

                $activity->logs()->save($log);

                return true;
            });
        } else {
            $result = $log->save();
        }

        if ($result) {
            return redirect()
                    ->route('organise::activity::log::modify', [$activity, $log])
                    ->with([
                        'message_type' => 'success',
                        'message_body' => '儲存成功'
                    ]);
        } else {
            return back()->withInput()->with([
                'message_type' => 'warning',
                'message_body' => '儲存失敗'
            ]);
        }
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
     * 取消發布單一日誌。
     *
     * @return \Illuminate\Http\Response
     */
    public function cancelPublish($activity, $log)
    {
        $organizer = (Auth::user())->profile;

        $activity = $organizer->activities()->find($activity);

        $log = $activity->logs()->find($log);

        $log->status = 0;

        $data['result'] = $log->save();

        $data['message'] = $data['result'] ? '日誌已取消發布' : '日誌取消發布失敗';

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
