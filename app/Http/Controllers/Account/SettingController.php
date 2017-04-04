<?php

namespace App\Http\Controllers\Account;

use Auth;
use Validator;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    /**
     * 顯示帳戶設定編輯畫面。
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['setting'] = Auth::user();
        
        return view('account.setting', $data);
    }

    /**
     * 回傳儲存帳戶設定時，請求資料的驗證結果。
     *
     * @return bool
     */
    protected function validator(array $data)
    {
        $rules = [
            'password' => 'sometimes|min:6|confirmed'
        ];

        return Validator::make($data, $rules);
    }

    /**
     * 儲存帳戶設定
     *
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        if ($request->has('password') && !empty($request->password)) {
            $account = Auth::user()->fill([
                'password' => bcrypt($request->input('password'))
            ]);

            if (!$account->save()) {
                $request->session()->flash('email', $account->email);
        
                $request->session()->flash('message_type', 'warning');

                $request->session()->flash('message_body', '儲存失敗');

                return view('account.setting');
            }
        }
        
        return redirect('/account/setting')->with([
            'message_type' => 'success',
            'message_body' => '儲存成功'
        ]);
    }
}
