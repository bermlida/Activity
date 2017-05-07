<?php

namespace App\Http\Controllers\Organise;

use Auth;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreActivityMessageRequest;
use App\Models\Message;
use App\Services\MessageService;

use App\Models\Account;

class ActivityMessageController extends Controller
{
    /**
     * 顯示主辦單位舉辦活動的列表畫面。
     *
     * @return \Illuminate\Http\Response
     */
    public function index($activity, Request $request)
    {
        $organizer = Auth::user()->profile;

        $activity = $organizer->activities()->find($activity);

        $data['scheduled_messages'] = $activity->messages()
            ->where('status', 1)
            ->orderBy('sending_time')
            ->paginate(10, ['*'], 'scheduled_page');

        $data['draft_messages'] = $activity->messages()
            ->where('status', 0)
            ->orderBy('updated_at', 'desc')
            ->paginate(10, ['*'], 'draft_page');

        $data['send_messages'] = $activity->messages()
            ->where('status', 2)
            ->orderBy('sending_time', 'desc')
            ->paginate(10, ['*'], 'send_page');

        $data['url_query'] = $request->only([
            'scheduled_page', 'draft_page', 'send_page'
        ]);

        $data['tab'] = $request->has('tab') ? $request->input('tab') : 'scheduled';

        $data['activity'] = $activity;

        return view('organise.activity-messages', $data);
    }

    /**
     * 顯示單一訊息的新增 / 編輯畫面。
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($activity, $message = null)
    {
        $data['organizer'] = (Auth::user())->profile;

        $data['activity'] = $data['organizer']->activities()->find($activity);
        
        if (!is_null($message)) {
            $data['message'] = $data['activity']->messages()->find($message);

            $data['form_action'] = route('organise::activity::message::update', [
                'activity' => $activity,
                'message' => $message
            ]);

            $data['form_method'] = 'PUT';

            $data['page_title'] = '編輯活動訊息';
        } else {
            $data['form_action'] = route(
                'organise::activity::message::store',
                ['activity' => $activity]
            );

            $data['form_method'] = 'POST';

            $data['page_title'] = '新增活動訊息';
        }

        return view('organise.activity-message', $data);
    }

    /**
     * 儲存單一活動訊息。
     *
     * @return \Illuminate\Http\Response
     */
    public function save(StoreActivityMessageRequest $request, $activity, $message = null)
    {
        $organizer = (Auth::user())->profile;

        $activity = $organizer->activities()->find($activity);

        if (!is_null($message)) {
            $message = $activity->messages()->find($message)->fill($request->all());

            $result = $message->save();
        } else {
            $message = new Message($request->all());

            $result = $activity->messages()->save($message);
        }

        if ($result) {
            $this->test($message);

            exit;

            return redirect()
                    ->route('organise::activity::message::modify', [$activity, $message])
                    ->with([
                        'message_type' => 'success',
                        'message_body' => '儲存成功'
                    ]);
        } else {
            $request->flash();

            $request->session()->flash('message_type', 'warning');

            $request->session()->flash('message_body', '儲存失敗');
            
            return redirect()
                    ->route('organise::activity::message::modify', [$activity, $message])
                    ->with([
                        'message_type' => 'warning',
                        'message_body' => '儲存失敗'
                    ]);
        }
    }
    
    protected function test($message)
    {
        // $user = Account::where('email', '')->first();
        app(MessageService::class)->sendMail($message);
        // $user->notify(new ActivityNotification($message));
    }

    /**
     * 刪除單一活動訊息。
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($activity, $message)
    {
        $organizer = (Auth::user())->profile;

        $activity = $organizer->activities()->find($activity);

        $message = $activity->messages()->find($message);

        $data['result'] = $message->delete();

        $data['message'] = $data['result'] ? '刪除成功' : '刪除失敗';

        return response()->json($data);
    }

    /**
     * 取消單一活動訊息發送排程。
     *
     * @return \Illuminate\Http\Response
     */
    public function cancel($activity, $message)
    {
        $organizer = (Auth::user())->profile;

        $activity = $organizer->activities()->find($activity);

        $message = $activity->messages()->find($message);

        $data['result'] = $message->fill(['status' => 0])->save();

        $data['message'] = $data['result'] ? '取消成功' : '取消失敗';

        return response()->json($data);
    }
}
